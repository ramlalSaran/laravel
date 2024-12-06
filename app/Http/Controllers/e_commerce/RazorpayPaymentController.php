<?php

namespace App\Http\Controllers\e_commerce;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class RazorpayPaymentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // dd('fdffd');
        return view('e-commerce.payment.payment');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request): RedirectResponse
    {
        $input = $request->all();
        dd($input);
  
        $api = new Api(env('RAZORPAY_KEY'), env('RAZORPAY_SECRET'));
  
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
  
        if(!empty($input['razorpay_payment_id'])) {

            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])
                                         ->capture(['amount'=>$payment['amount']]); 
  
            } catch (Exception $e) {
                return redirect()->back()
                                 ->with('error', $e->getMessage());
            }
            
        }

        return redirect()->back()
                         ->with('success', 'Payment successful');
    }


    /**
     * Store a newly created resource in storage.
     */
    // public function store(Request $request)
    // {
    //     //
    // }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
