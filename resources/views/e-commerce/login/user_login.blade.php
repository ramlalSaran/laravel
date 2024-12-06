@extends('e-commerce.layouts.layout')
@section('title','user login')
@section('section')

     <!-- Breadcrumb Start -->
     <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{route('home')}}">Home</a></li>
                <li class="breadcrumb-item"><a href="{{route('register_form')}}">Register</a></li>
                <li class="breadcrumb-item active">Login</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->
    
    <!-- Login Start -->
    <div class="login">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <h2 class="mb-4">User Login</h2>
                    <div class="login-form">
                        {{-- form start --}}
                        @if (session('error'))
                        <div class="alert alert-danger alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('error') }}
                        </div>
                        @endif
                        <form action="{{route('User_loginPost')}}" method="POST">
                            @csrf
    
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>E-mail </label>
                                    <input class="form-control @error('email') border-danger @enderror" type="email" placeholder="E-mail" name="email" >
                                    @error('email')
                                        <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
    
                                <div class="col-md-12 mb-3">
                                    <label>Password</label>
                                    <input class="form-control @error('password') border-danger @enderror" type="password" placeholder="Password" name="password" >
                                    @error('password')
                                    <span class="text-danger">{{$message}}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12 mb-3">
                                    <div class="custom-control custom-checkbox">
                                        <input type="checkbox" class="custom-control-input" id="newaccount">
                                        <label class="custom-control-label" for="newaccount">Keep me signed in</label>
                                    </div>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <button type="submit" class="btn btn-primary">Submit</button>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <a href="{{route('register_form')}}" class="btn btn-secondary">Create Account</a>
                                </div>
                                
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Login End -->
    
@endsection