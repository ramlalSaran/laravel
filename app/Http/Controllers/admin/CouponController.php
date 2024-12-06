<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Models\Coupon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;


class CouponController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('coupon_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Coupon::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })

                ->addColumn('action', function ($row) {
                   $viewBtn='';
                    if (auth()->user()->can('coupon_show')) {
                        $viewBtn = '<a class="dropdown-item" href="' . route('coupon.show', $row->id) . '">
                                        <i class="fas fa-eye"></i> View
                                    </a>';
                    }
                    $editBtn='';
                    if(auth()->user()->can('coupon_edit')){
                        $editBtn = '<a class="dropdown-item" href="' . route('coupon.edit', $row->id) . '">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>';
                    }
                    $deleteBtn='';
                    if (auth()->user()->can('coupon_delete')) {
                        $deleteBtn = '<form action="'. route('coupon.destroy', $row->id) .'" method="POST" style="display:inline;">
                            '. csrf_field() .'
                            '. method_field("DELETE") .'
                            <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this coupon?\');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>';
                    }

                    $dropdown = '<div class="btn-group">
                        <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Action
                        </button>
                        <div class="dropdown-menu">
                            ' . $viewBtn . '
                            ' . $editBtn . '
                            <div class="dropdown-divider"></div>
                            ' . $deleteBtn . '
                        </div>
                    </div>';
    
                    return $dropdown;
                })
                
                
                ->rawColumns(['action'])
                ->make(true);
        }
        return view('admin.coupons.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('coupon_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.coupons.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('coupon_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validateData = $request->validate([
            'title'            => 'required',
            'coupon_code'      => 'required',
            'status'           => 'required',
            'valid_from'       => 'required',
            'valid_to'         => 'required',
            'discount_amount'  => 'required',
        ]);
       
        $create = Coupon::create([
            'title'            => $validateData['title'],
            'coupon_code'      => $validateData['coupon_code'],
            'status'           => $validateData['status'],
            'valid_from'       => $validateData['valid_from'],
            'valid_to'         => $validateData['valid_to'],
            'discount_amount'  => $validateData['discount_amount'],
        ]);
        if ($create) 
        {
            return \redirect()->route('coupon.index')->with('success','Coupon add successfully');
        }else{
            back()->with('error','Coupon Not add ');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('coupon_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $coupon = Coupon::where('id',$id)->first();
        return view('admin.coupons.show',compact('coupon'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('coupon_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $coupon = Coupon::where('id',$id)->first();
        return view('admin.coupons.edit',compact('coupon'));   
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('coupon_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validateData = $request->validate([
            'title'            => 'required',
            'coupon_code'      => 'required',
            'status'           => 'required',
            'valid_from'       => 'required',
            'valid_to'         => 'required',
            'discount_amount'  => 'required',
        ]);
        $update=Coupon::where('id',$id)->update([
            'title'            => $validateData['title'],
            'coupon_code'      => $validateData['coupon_code'],
            'status'           => $validateData['status'],
            'valid_from'       => $validateData['valid_from'],
            'valid_to'         => $validateData['valid_to'],
            'discount_amount'  => $validateData['discount_amount'],
        ]);


        if ($update) {
            return \redirect()->route('coupon.index')->with('success','Coupon edit successfully');
        }else{
            back()->with('error','Coupon Not add ');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('coupon_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $delete = Coupon::find($id)->delete();
        if ($delete) {
            return \redirect()->route('coupon.index')->with('success','Coupon delete successfully');
        }else{
            return \redirect()->route('coupon.index')->with('error','Coupon not delete');
        }
    }
}
