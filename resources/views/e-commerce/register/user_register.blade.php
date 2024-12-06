@extends('e-commerce.layouts.layout')
@section('title','user register')
@section('section')

     <!-- Breadcrumb Start -->
     <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Register</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->
    
    <!-- Login Start -->
    <div class="login d-flex justify-content-center align-items-center">
        <div class="container">
            <h2 class="mb-4">User Register</h2>
            <div class="row">
                <div class="col-lg-12">
                    <div class="register-form">
                        {{-- form star --}}
                        <form action="{{ route('registerPost') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12 mb-3">
                                    <label>Name</label>
                                    <input class="form-control @error('name') border-danger @enderror" type="text" placeholder="Name" name="name" value="{{ old('name') }}">
                                    @error('name')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                
                                <div class="col-md-12 mb-3">
                                    <label>E-mail</label>
                                    <input class="form-control @error('email') border-danger @enderror" type="email" placeholder="E-mail" name="email" value="{{ old('email') }}">
                                    @error('email')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label>Mobile No</label>
                                    <input class="form-control @error('phone') border-danger @enderror" type="tel" placeholder="Mobile No" name="phone" value="{{ old('phone') }}">
                                    @error('phone')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label>Password</label>
                                    <input class="form-control @error('password') border-danger @enderror" type="password" placeholder="Password" name="password">
                                    @error('password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label>Retype Password</label>
                                    <input class="form-control @error('retype_password') border-danger @enderror" type="password" placeholder="Retype Password" name="retype_password">
                                    @error('retype_password')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="col-md-12 mb-3">
                                    <label>Gender</label>
                                    <div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderMale" value="m" {{ old('gender') == 'm' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genderMale">Male</label>
                                            
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderFemale" value="f" {{ old('gender') == 'f' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genderFemale">Female</label>
                                        </div>
                                        <div class="form-check form-check-inline">
                                            <input class="form-check-input" type="radio" name="gender" id="genderOther" value="o" {{ old('gender') == 'o' ? 'checked' : '' }}>
                                            <label class="form-check-label" for="genderOther">Other</label>
                                        </div>
                                    </div>
                                    @error('gender')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                        
                                <div class="col-md-12">
                                    <button type="submit" class="btn btn-primary">Submit</button>
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