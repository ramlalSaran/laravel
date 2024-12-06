<?php

namespace App\Http\Controllers\admin;
use Gate;
use App\Models\Attribute;
use App\Models\Attributevalue;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AttributevalueController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('attributevalue_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()){
            $data = Attributevalue::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })

                ->addColumn('attribute_id', function ($row) {
                   return implode(',', $row->attribute()->pluck('name')->toArray());
                })

                ->addColumn('action', function ($row) {
                   $viewBtn='';

                    if (auth()->user()->can('attributevalue_show')) {
                        $viewBtn = '<a class="dropdown-item" href="' . route('attributevalue.show', $row->id) . '">
                                        <i class="fas fa-eye"></i> View
                `                    </a>';
                    }
                    $editBtn='';
                    if(auth()->user()->can('attributevalue_edit')){
                        $editBtn = '<a class="dropdown-item" href="' . route('attributevalue.edit', $row->id) . '">
                                        <i class="fas fa-edit"></i> Edit
                                    </a>';
                    }
                    $deleteBtn='';
                    if (auth()->user()->can('attributevalue_delete')) {
                        $deleteBtn = '<form action="'. route('attributevalue.destroy', $row->id) .'" method="POST" style="display:inline;">
                            '. csrf_field() .'
                            '. method_field("DELETE") .'
                            <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this attributevalue?\');">
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
                
                
                ->rawColumns(['action','image'])
                ->make(true);
        }

        return view('admin.attributevalue.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('attributevalue_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $attributes=Attribute::all();
        return view('admin.attributevalue.create',compact('attributes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('attributevalue_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        
        $validate=$request->validate([
            'attribute_id'          => 'required',
            'name'                  => 'required',
            'status'                => 'required',
        ],[
            'attribute_id.required' => 'The attribute field is required',
        ]);

        $create = Attributevalue::create([
            'attribute_id' => $validate['attribute_id'],
            'name'         => $validate['name'],
            'status'       => $validate['status'],
        ]);
        if ($create) 
        {
           return \redirect()->route('attributevalue.index')->with('success','Attribute value add successfully');
        }else {
            return back()->with('error', 'Some thing went wrong..');
        }
       
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('attributevalue_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $attributevalue = Attributevalue::where('id',$id)->first();
        return view('admin.attributevalue.show' ,compact('attributevalue'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('attributevalue_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
         
        $attributes = Attribute::all();
        $attributevalue = Attributevalue::where('id',$id)->first();
        return view('admin.attributevalue.edit',compact('attributes','attributevalue'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('attributevalue_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validate = $request->validate([
            'attribute_id'          => 'required',
            'name'                  => 'required',
            'status'                => 'required',
        ],[
            'attribute_id.required' => 'The attribute field is required',
        ]);
        $create = Attributevalue::where('id',$id)->update([
            'attribute_id'          => $validate['attribute_id'],
            'name'                  => $validate['name'],
            'status'                => $validate['status'],
        ]);

        if ($create) 
        {
           return \redirect()->route('attributevalue.index')->with('success','Attribute value Edit successfully');
        }else {
            return back()->with('error', 'Some thing went wrong..');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('attributevalue_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $delete = Attributevalue::where('id',$id)->delete();
        if ($delete) 
        {
            return \redirect()->route('attributevalue.index')->with('success','Attribute value Edit successfully');
        }else{
            return \redirect()->route('attributevalue.index')->with('error','Some thing went wrong..');
        }
    }
}