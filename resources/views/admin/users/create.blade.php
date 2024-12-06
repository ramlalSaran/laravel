@extends('admin.layouts.admin-layout')
@section('title', 'User Create')
@section('content')
    <div class="card mb-4">
        <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
            <h6 class="m-0 font-weight-bold text-primary">User</h6>
        </div>

        @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('error') }}
            </div>
        @endif

        <div class="card-body">
            <form action="{{ route('user.store') }}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="name">Name</label>
                    <input type="text" id="name" name="name" class="form-control @error('name') border-danger @enderror" value="{{ old('name') }}" placeholder="Name">
                    @error('name')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email" class="form-control @error('email') border-danger @enderror" value="{{ old('email') }}" placeholder="email">
                    @error('email')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password" class="form-control @error('password') border-danger @enderror" placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="con_password">Confirm-password</label>
                    <input type="password" id="con_password" name="con_password"  class="form-control @error('con_password') border-danger @enderror" placeholder="Confirm-password">
                    @error('con_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="profile_image">Profile(optional)</label>
                    <input type="file" id="profile_image" name="profile_image" class="form-control @error('profile_image') border-danger @enderror">
                    @error('profile_image')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>

                <div class="form-group">
                    <label for="phone">phone</label>
                    <input type="tel" id="phone" name="phone" class="form-control @error('phone') border-danger @enderror" placeholder="phone">
                    @error('phone')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="gender">Gender</label>
                    <div class="row">
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="radio" id="gender_male" class="form-check-input" name="gender" value="m">
                                <label class="form-check-label" for="gender_male">Male</label>
                            </div>
                        </div>
                        <div class="col-md-2">
                            <div class="form-check">
                                <input type="radio" id="gender_female" class="form-check-input" name="gender" value="f">
                                <label class="form-check-label" for="gender_female">Female</label>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="form-group">
                    <label for="is_admin">Is_Admin</label>
                    <select class="form-control" id="is_admin" aria-describedby="emailHelp"
                        placeholder="" name="is_admin">
                        <option value="">Is Admin</option>
                        <option value="1" {{old('is_admin')== 1 ? 'selected' : ''}}>Yes</option>
                        <option value="0" {{old('is_admin')== 0 ? 'selected' : ''}}>No</option>
                    </select>
                    @error('is_admin')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                
                


                <div class="form-group">
                    <label for="roles">Roles(optional)</label>
                    <div class="row">
                        @foreach ($roles as $role)
                            <div class="col-md-4">
                                <div class="form-check">
                                    <input type="checkbox" class="form-check-input" name="roles[]" value="{{ $role->name }}">
                                    <label class="form-check-label" for="role_{{ $role->id }}">{{ $role->name }}</label>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
@endsection
