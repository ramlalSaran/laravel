@extends('admin.layouts.admin-layout')

@section('content')

<div class="container-fluid">
    <div class="row justify-content-center mt-5">
        <div class="col-md-8">
            <!-- Navigation Link -->
            <div class="mb-3">
                <a href="{{ route('dashboard.index') }}" class="btn btn-primary">Home</a>
            </div>

            <div class="card shadow-lg">
                <div class="card-header text-center bg-primary text-white">
                    <h3>Profile</h3>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <!-- User Image (Clickable) -->
                            <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') }}"  alt="User Image"  class="img-fluid rounded-circle"  style="width: 150px;"  onclick="openImage('{{ auth()->user()->getFirstMediaUrl('profile_image') }}')">
                        </div>
                        <div class="col-md-8">
                            <!-- User Name -->
                            <h4>NAME: {{ strtoupper(auth()->user()->name) }}</h4>
                            <!-- User Email -->
                            <br>
                            <h4>EMAIL: {{ strtoupper(auth()->user()->email) }}</h4>

                            <br>
                            <div>
                                <a href="{{ route('user.userPassword') }}" class="btn btn-warning">Change Password</a>
                                <form action="{{ route('admin.logout') }}" method="GET" style="display:inline;">
                                    @csrf
                                    <button type="submit" class="btn btn-danger">Logout</button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function openImage(url) {
        window.open(url, '_blank'); // Open the image in a new tab
    }
</script>

@endsection
