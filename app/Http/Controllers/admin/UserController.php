<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\User;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\DataTables;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Response;
use Gate ;


class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        abort_if(Gate::denies('user_index'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        if ($request->ajax()) {
            $data = User::select('*');
            // dd($data);
            return Datatables::of($data)
                ->addIndexColumn()
                ->addcolumn('gender',function($gender){
                    return $gender->gender == 'm' ? 'Male' :'Female';
                })
                ->addcolumn('is_admin',function($is_admin){
                    return $is_admin->is_admin == 1 ? 'Admin' :'Not Admin';
                })
                ->addColumn('image', function ($row) {
                    $image= $row->getFirstMediaUrl('profile_image');
                    if ($image) {
                        return "<img src='$image' alt='User Image' style='width: 70px; height: 70px;'>";
                    } else {
                        return 'No user image';
                    }
                })
                ->addColumn('roles', function ($row) {
                    return implode(',',$row->roles()->pluck('name')->toArray());
                })
                ->addColumn('action', function ($row) {
                    $editBtn = '<a class="dropdown-item" href="' . route('user.edit', $row->id) . '">
                                    <i class="fas fa-edit"></i> Edit
                                </a>';
                    $deleteBtn = '<form action="'. route('user.destroy', $row->id) .'" method="POST" style="display:inline;">
                        '. csrf_field() .'
                        '. method_field("DELETE") .'
                        <button type="submit" class="dropdown-item" onclick="return confirm(\'Are you sure you want to delete this user?\');">
                            <i class="fas fa-trash-alt"></i> Delete
                        </button>
                    </form>';

                    $dropdown = '<div class="btn-group">
                    <button type="button" class="btn btn-warning dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        <i class="fas fa-cog"></i>
                    </button>
                    <div class="dropdown-menu">
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
        return \view('admin.users.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        abort_if(Gate::denies('user_create'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $roles = Role::all();
        return view('admin.users.create',compact('roles'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        abort_if(Gate::denies('user_store'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        $request->validate([
            'name'                   => 'required|min:3',
            'email'                  => 'required|unique:users,email|email',
            'password'               => 'required|min:8|max:15',
            'con_password'           => 'required|same:password',
            'phone'                  => 'required|min:10',
            'gender'                 => 'required',
            'is_admin'               => 'required',
            'profile_image'          => 'max:3072'
        ], [
            'name.required'          => 'Name is a required field.',
            'name.min'               => 'Name must be at least 3 characters.',
            'email.required'         => 'Email is a required field.',
            'email.unique'           => 'This email is already taken.',
            'email.email'            => 'Please provide a valid email address.',
            'password.required'      => 'Password is a required field.',
            'password.min'           => 'Password must be at least 8 characters.',
            'password.max'           => 'Password must not exceed 15 characters.',
            'con_password.required'  => 'Password confirmation is required.',
            'con_password.same'      => 'Password confirmation must match the password.',
            'phone.required'         => 'Phone number is a required field.',
            'phone.min'              => 'Phone number must be at least 10 digits.', 
            'gender.required'        => 'Gender selection is required.',
            'is_admin.required'      => 'Admin status is required.',
            'profile_image.max'      => 'Image size must not exceed 3 MB.',
        ]);
        
        $user=User::create([
            'name'       => $request->name,
            'email'      => $request->email,
            'password'   => Hash::make($request->password),
            'phone'      => $request->phone,
            'gender'     => $request->gender,
            'is_admin'   => $request->is_admin

        ]);

        $user->syncRoles($request->input('roles'));

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) 
        {
            $user->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }
        return \redirect()->route('user.index')->with('success','user add successfully');   
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        // abort_if(Gate::denies('user_show'),Response::HTTP_FORBIDDEN,'403 Forbidden');
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        abort_if(Gate::denies('user_edit'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        $user = User::where('id',$id)->first();
        $roles = Role::all();

        return view('admin.users.edit',compact('user','roles'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        abort_if(Gate::denies('user_update'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        
        //    dd($request->all());
           $request->validate([
            'name'              => 'required|min:3',
            'email'             => 'required|email',
            'phone'             => 'required|min:10', 
            'gender'            => 'required',
            'is_admin'          => 'required', 
            'profile_image'     => 'max:3072'
        ], [
            'name.required'     => 'Name is a required field.',
            'name.min'          => 'Name must be at least 3 characters.',
            'email.required'    => 'Email is a required field.',
            'email.email'       => 'Please provide a valid email address.',
            'phone.required'    => 'Phone number is a required field.',
            'phone.min'         => 'Phone number must be at least 10 digits.', 
            'gender.required'   => 'Gender selection is required.',
            'is_admin.required' => 'Admin status is required.',
            'profile_image.max' => 'Image size must not exceed 3 MB.',
        ]);
        
        $update=[
            'name'      => $request->name,
            'email'     => $request->email,
            'phone'     => $request->phone,
            'gender'    => $request->gender,
            'is_admin'  => $request->is_admin,
        ];

        $updateUser=User::where('id',$id)->update($update);
        $userId=User::find($id);

        if ($request->hasFile('profile_image') && $request->file('profile_image')->isValid()) 
        {
            $userId->clearMediaCollection('profile_image');
            $userId->addMediaFromRequest('profile_image')->toMediaCollection('profile_image');
        }

        $userId->syncRoles($request->input('roles'));

        return \redirect()->route('user.index')->with('success','User Update SuccessFully....');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        abort_if(Gate::denies('user_delete'),Response::HTTP_FORBIDDEN,'403 Forbidden');

        User::where('id',$id)->delete();
        return \redirect()->route('user.index')->with('success','User are deleted ');
    }

    public function userPassword()
    {
        return \view('admin.users.changePassword');
    }
    public function updatePassword(Request $request)
    {
        $request->validate([
            'oldPassword'            => 'required|min:8|max:15',
            'password'               => 'required|min:8|max:15',
            'con_password'           => 'required|same:password',
        ], [
            'oldPassword.required'   => 'Old password is required.',
            'oldPassword.min'        => 'Old password must be at least 8 characters.',
            'oldPassword.max'        => 'Old password must not exceed 15 characters.',
            'password.required'      => 'Password is a required field.',
            'password.min'           => 'Password must be at least 8 characters.',
            'password.max'           => 'Password must not exceed 15 characters.',
            'con_password.required'  => 'Password confirmation is required.',
            'con_password.same'      => 'Password confirmation must match the password.',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->oldPassword,$user->password)) 
        {
            return \redirect()->route('user.userPassword')->with('error','Old Password Not Match');
        }
        else
        {
            $updatePass=[
                'password'=>Hash::make($request->password)
            ];
            $user->update($updatePass);
            return \redirect()->route('admin.logout');
        }
        
    }
    public function profile()
    {
        abort_if(Gate::denies('profile'),Response::HTTP_FORBIDDEN,'403 Forbidden');
        return view('admin.users.profile');
    }
}