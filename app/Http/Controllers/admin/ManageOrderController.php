<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Mail\Email;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderAddress;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Barryvdh\DomPDF\Facade\PDF;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class ManageOrderController extends Controller
{
    public function index(Request $request){
        abort_if(Gate::denies('manage_order'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        if ($request->ajax()){
            $data = Order::all();
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('show', function ($row) {
                    return '<a href="' . route('admin.orderShow',$row->id). '" class="btn btn-primary" > <i></> Show</a>';
                })

                
                ->addColumn('invoice', function ($row) {
                    return '<a href="'. route('generateInvoice',$row->id) . '" class="btn btn-success" > invoice </a>';
                })
                ->addColumn('SendMail', function ($row) {
                    return '<a href="'. route('admin.orderShow',$row->id .'/sendEmail') . '" class="btn btn-primary" > Send Mail </a>';
                })

                ->rawColumns(['invoice','show','SendMail'])
                ->make(true);
        }  
        return view('admin.manage_orders.index');
    }



    function orderShow($id)
    {
        abort_if(Gate::denies('orderShow'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $order = Order::where('id',$id)->first();
        $orderItems = OrderItem::where('order_id',$order->id)->with('product')->get();
        // dd($orderItems);
        return view('admin.manage_orders.show',compact('order','orderItems'));
    }

    function peyment(){
        return view('e-commerce.payment.payment');
    }





    function orders($id){
        $user_id=  Auth::user()->id;
        // dd($user_id);
        $order = Order::where('user_id',$user_id)->where('id',$id)->with('items')->with('addresses')->first();
        // dd($order);
        $orderItems = OrderItem::where('order_id',$order->id)->with('product')->get();
        // dd($orderItems);
        // dd($orders);
        return view('e-commerce.profile.orderShow',compact('order','orderItems'));
    
    }

    public function generateInvoice($id)
    {
        abort_if(Gate::denies('generateInvoice'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $order = Order::with('items')->with('addresses')->where('id',$id)->first();

        $pdf   = PDF::loadView('e-commerce.profile.invoice', compact('order'));

        return $pdf->download('invoice_'.$order->id.'.pdf');
    }


    public function sendEmail($id)
    {
        // abort_if(Gate::denies('sendEmail'),Response::HTTP_FORBIDDEN,'403 Forbidden'); 
        $order = Order::with(['items', 'addresses'])->where('id', $id)->first();

        if (!$order) {
            return redirect()->route('order')->with('error', 'Order not found.');
        }

        try {
            Mail::to($order->email)->send(new Email($order));
        } catch (\Exception $e) {
            return redirect()->route('order')->with('error', 'Email could not be sent: ' . $e->getMessage());
        }
        return redirect()->route('order')->with('success', 'Email sent successfully to ' . $order->email);
    }

}
