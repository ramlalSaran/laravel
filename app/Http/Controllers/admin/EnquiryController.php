<?php

namespace App\Http\Controllers\admin;
use Gate;
use App\Models\Enquiry;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class EnquiryController extends Controller
{
    public function index(Request $request){
        abort_if(Gate::denies('enquiry_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Enquiry::all();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                    if (auth()->user()->can('enquiry_read')) {
                    if ($row->status == 2) {
                        $un_read = '<a href="'.route('enquiries.enquiryRead',$row->id).'" class="btn btn-danger">UnRead</a>';
                    } else {
                        $un_read = '<a href="" class="btn btn-success">Read</a>';
                    }
                    return $un_read;
                }else{
                    return  $un_read="Not Permission";
                }
                })
                ->addColumn('delete', function ($row) {
                    if (auth()->user()->can('enquiry_delete')) {
                        $deleteBtn = '<form action="'.\route('enquiries.delete',$row->id).'" method="POST" style="display:inline;">
                            '. csrf_field() .'
                            '. method_field("DELETE") .'
                            <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this Enquiry?\');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>';

                    return $deleteBtn;
                    }else{
                        return  $deleteBtn = 'Not Permission';
                    }
                })
                
                
                ->rawColumns(['delete','status'])
                ->make(true);
        }
        return \view('admin.enquiries.index');
    }

    public function delete(string $id){
        abort_if(Gate::denies('enquiry_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        
        Enquiry::where('id',$id)->delete();
        return \redirect()->route('enquiries.index')->with('success','Enquiry Deleted SuccessFully');
    }
    public function enquiryRead(string $id){
        abort_if(Gate::denies('enquiry_read'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $update = Enquiry::where('id',$id)->update([
            'status' => 1,
        ]);
        if ($update) {
            return \redirect()->route('enquiries.index')->with('success','alert("Enquiry Read SuccessFully")');
        }else{
            return \redirect()->route('enquiries.index')->with('error','alert("Something went wrong!")');

        }
    }
}
