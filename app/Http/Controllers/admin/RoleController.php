<?php

namespace App\Http\Controllers\admin;

use Gate;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Yajra\DataTables\DataTables;
use Spatie\Permission\Models\Role;
use App\Http\Controllers\Controller;
use Spatie\Permission\Models\Permission;

class RoleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('role_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) 
        {
            $data = Role::select('*');
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('permissions', function ($row) {
                    // Return the permissions wrapped in a span with a class for styling
                    return '<span class="text-wrap">' . implode(', ', $row->permissions()->pluck('name')->toArray()) . ' </span>';
                })
                ->addColumn('action', function ($row) {
                    
                    $editBtn = '<a href="' . route('role.edit', $row->id) . '" class="edit btn btn-warning btn-sm">Edit</a>';
                    $deleteBtn = '<form action="'. route('role.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="btn btn-danger btn-sm" onclick="return confirm(\'Are you sure you want to delete this Permission?\');">Delete</button>
                    </form>';
        
                    return  $editBtn . ' ' . $deleteBtn;
                })
                ->rawColumns(['action','permissions'])
                ->make(true);
        }
        return view('admin.Role.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('role_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $permissions=Permission::all();
        return view('admin.Role.create',compact('permissions'));

    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('role_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'role'           => 'required|unique:roles,name'
        ],[
            'role.required'  => 'The role name is required.',
            'role.unique'    => 'This role name has already been taken.'
        ]);
        $role = Role::create([
            'name'           => $request->role
        ]);
        // permission sync in role
        $role->syncPermissions($request->input('permissions'));
        return \redirect()->route('role.index')->with('success','role add successfully...');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('role_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('role_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $role = Role::where('id',$id)->first();
        $permissions = Permission::all();
        return view('admin.Role.edit',compact('role','permissions'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('role_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'role'          => 'required'
        ], [
            'role.required' => 'The role name is required.',
        ]);

        $update=[
            'name'          => $request->role
        ];
        Role::where('id',$id)->update($update);
        $roleUpdate = Role::find($id);

        $roleUpdate->syncPermissions($request->input('permissions'));
        
        return \redirect()->route('role.index')->with('success','role Edit  successfully...');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('role_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        Role::where('id',$id)->delete();
        return \redirect()->route('role.index')->with('success','role Delete successfully...');

    }
}