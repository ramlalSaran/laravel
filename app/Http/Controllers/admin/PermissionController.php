<?php

namespace App\Http\Controllers\admin;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('permission_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = Permission::select('*');
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $editBtn = '<a href="' . route('permission.edit', $row->id) . '" class="edit btn btn-warning btn-sm">Edit</a>';
                    $deleteBtn = '<form action="'. route('permission.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this Permission?\');">Delete</button>
                    </form>';
        
                    return  $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }

        return view('admin.permission.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('permission_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.permission.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('permission_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'permission'          => 'required|min:3|max:50|unique:permissions,name',
        ], [
            'permission.required' => 'The permission field is required.',
            'permission.min'      => 'The permission must be at least 3 characters.',
            'permission.max'      => 'The permission may not be greater than 50 characters.',
            'permission.unique'   => 'This permission name has already been taken.',
        ]);
        $create=[
            'name'  => $request->permission
        ];

        $createTrue = Permission::create($create);
        
        if ($request->new_permissions) 
        {
            foreach ($request->new_permissions as $key => $permission) 
            {
                Permission::create([
                    'name'  =>  $permission
                ]);
            }
        }
        return redirect()->route('permission.index')->with('success','Permission Add SuccessFully');
        
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('permission_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('permission_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $permission=Permission::where('id',$id)->first();
        return view('admin.permission.edit',compact('permission'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('permission_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'permission'            => 'required|min:3|max:50',
        ],[
            'permission.required'   => 'The permission field is required.',
            'permission.min'        => 'The permission must be at least 3 characters.',
            'permission.max'        => 'The permission may not be greater than 50 characters.'
        ]);

        $updata=[
            'name'  => $request->permission
        ];
        Permission::where('id',$id)->update($updata);

        if ($request->new_permissions) 
        {
            foreach ($request->new_permissions as $key => $permission) 
            {
                Permission::create([
                    'name' => $permission
                ]);
            }
        }
        return redirect()->route('permission.index')->with('success','Permission Edit SuccessFully');
        
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('permission_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $delete=Permission::where('id',$id)->delete();
        if ($delete) 
        {
            return redirect()->route('permission.index')->with('success','Permission Deleted SuccessFully');
        }else
        {
            return redirect()->route('permission.index')->with('error','Permission Not Delete ');
        }
    }
}