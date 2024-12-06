<?php

namespace App\Http\Controllers\admin;

use Gate;
use App\Models\Attribute;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use App\Models\Attributevalue;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;

class AttributeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('attribute_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) 
        {
            $data = Attribute::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('status', function ($row) {
                   return $row->status == 1 ? 'Enable' : 'Disable';
                })

                ->addColumn('attribute_values', function ($row) {
                   return implode(',',$row->attributeValues()->pluck('name')->toArray());
                })

                ->addColumn('is_variant', function ($row) {
                   return $row->is_variant == 1 ? 'Yes' : 'No';
                })

                ->addColumn('action', function ($row) {
                    $viewBtn='';
                   if (auth()->user()->can('attribute_show')){
                       $viewBtn = '<a class="dropdown-item" href="' . route('attribute.show', $row->id) . '"><i class="fas fa-eye"></i> View</a>';
                   }
                   
                   $editBtn='';

                   if (auth()->user()->can('attribute_edit')){
                    $editBtn = '<a class="dropdown-item" href="' . route('attribute.edit', $row->id) . '"><i class="fas fa-edit"></i> Edit</a>';
                   }
                   $deleteBtn='';

                   if (auth()->user()->can('attribute_delete')) {
                    $deleteBtn = '<form action="'. route('attribute.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                            <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this attribute?\');">
                                <i class="fas fa-trash-alt"></i> Delete
                            </button>
                        </form>';
                   }

                    $dropdown = '<div class="btn-group">
                    <button type="button" class="btn btn-success dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Action</button>
                    <div class="dropdown-menu">' . $viewBtn . '' . $editBtn . '
                        <div class="dropdown-divider"></div>
                        ' . $deleteBtn . '
                    </div>
                </div>';
    
                    return $dropdown;
                })
                
                
                ->rawColumns(['action','image'])
                ->make(true);
        }
        return view('admin.attributes.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('attribute_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.attributes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('attribute_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validate=$request->validate([
            'name'                   => 'required',
            'is_variant'             => 'required',
            'status'                 => 'required',
            'attribute_value_name'   => 'required',
            'attribute_value_status' => 'required'
        ]);

        $key = $validate['name'];
        $name_key = strtolower($key);
        $name_key = preg_replace('/[^a-zA-Z0-9-]+/', '-', $name_key);

        $create=Attribute::create([
            'name'                 => $validate['name'],
            'status'               => $validate['status'],
            'name_key'             => $name_key,
            'is_variant'           => $validate['is_variant'],
        ]);

        foreach ($request->attribute_value_name as $key => $attribute_value_name) 
        {
            $status=$request->attribute_value_status[$key];
            Attributevalue::create([
                'attribute_id' => $create->id,
                'name'         => $attribute_value_name,
                'status'       => $status
            ]);
        }

        if ($create) 
        {
            return \redirect()->route('attribute.index')->with('success','Attribute add successfully 👍');
        }else{
            return \redirect()->route('attribute.create')->with('error','Some thing went wrong 🤷‍♂️😮');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        abort_if(Gate::denies('attribute_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $attribute=Attribute::where('id',$id)->first();
        return view('admin.attributes.show',compact('attribute' ));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('attribute_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $attributevalues=Attributevalue::where('attribute_id',$id)->get();
        $attribute=Attribute::where('id',$id)->first();
        return view('admin.attributes.edit',compact('attribute','attributevalues'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('attribute_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $validate = $request->validate([
            'name'        => 'required',
            'is_variant'  => 'required',
            'status'      => 'required'
        ]);

        
        $key = $validate['name'];
        $name_key = strtolower($key);
        $name_key = preg_replace('/[^a-zA-Z0-9-]+/', '-', $name_key);

        $update = Attribute::where('id',$id)->update([
            'name'        => $validate['name'],
            'is_variant'  => $validate['is_variant'],
            'name_key'    => $name_key,
            'status'      => $validate['status']
        ]);

        if ($request->attribute_value_name) 
        {
            foreach ($request->attribute_value_name as $key => $attribute_value_name) 
            {
                $status = $request->attribute_value_status[$key];
                $atvId = $request->attribute_value_id[$key];
    
                Attributevalue::where('id', $atvId)->update([
                    'name'   => $attribute_value_name,
                    'status' => $status
                ]);
            }
        }

        if ($request->new_attribute_value_name) 
        {
            foreach ($request->new_attribute_value_name as $key => $attribute_value_name) 
            {
                $status=$request->new_attribute_value_status[$key];
                Attributevalue::create([
                    'attribute_id'  => $id,
                    'name'          => $attribute_value_name,
                    'status'        => $status
                ]);
            }
        }
        

        if ($update) 
        {
            return \redirect()->route('attribute.index')->with('success','Attribute Update successfully 👍');
        }else{
            return \redirect()->route('attribute.edit')->with('error','Some thing went wrong 🤷‍♂️😮');
        }

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('attribute_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $delete = Attribute::where('id',$id)->delete();
        if ($delete) 
        {
            return \redirect()->route('attribute.index')->with('success','Attribute Delete successfully 😮');
        }else{
            return \redirect()->route('attribute.index')->with('error','Attribute No Delete  😔');
        } 
    }
}