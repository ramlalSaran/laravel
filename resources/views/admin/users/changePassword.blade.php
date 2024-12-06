@extends('admin.layouts.admin-layout')
@section('title','User Create')
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
            <form action="{{route('user.updatePassword')}}" method="post" enctype="multipart/form-data">
                @csrf
                <div class="form-group">
                    <label for="email">Email</label>
                    <input type="email" id="email" name="email"
                        class="form-control @error('email') border-danger @enderror" disabled value="{{auth()->user()->email}}"
                        placeholder="email">
                        <span class="text-danger">You are not change this email</span>
                   
                </div>
                <div class="form-group">
                    <label for="oldPassword">Old Password</label>
                    <input type="password" id="oldPassword" name="oldPassword"
                        class="form-control @error('oldPassword') border-danger @enderror" placeholder="oldPassword">
                    @error('oldPassword')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" id="password" name="password"
                        class="form-control @error('password') border-danger @enderror" placeholder="Password">
                    @error('password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <div class="form-group">
                    <label for="con_password">Confirm-password</label>
                    <input type="password" id="con_password" name="con_password"
                        class="form-control @error('con_password') border-danger @enderror" placeholder="Confirm-password">
                    @error('con_password')
                        <span class="text-danger">{{ $message }}</span>
                    @enderror
                </div>
                <button type="submit" class="btn btn-warning">Change Password</button>
            </form>
        </div>
    </div>
@endsection
