@extends('e-commerce.layouts.layout')
@section('title', 'User Profile')
@section('section')
{{-- @dd(auth()->user()-); --}}

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">My Account</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- My Account Start -->
    <div class="my-account">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <div class="nav flex-column nav-pills" role="tablist" aria-orientation="vertical">
                        {{-- <a class="nav-link active" id="dashboard-nav" data-toggle="pill" href="#dashboard-tab" role="tab"><i class="fa fa-tachometer-alt"></i>Dashboard</a> --}}
                        <a class="nav-link active" id="account-nav" data-toggle="pill" href="#account-tab" role="tab">
                            <!-- Check if the user has an image in the 'image' media collection -->
                            @if(auth()->user()->getFirstMediaUrl('profile_image'))
                            <!-- Display the user's image with rounded shape -->
                            <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') }}" alt="User Image" 
                            style="border-radius: 50%; object-fit: cover; width: 20px; height: 20px;">&nbsp;
                        
                            @else
                            <!-- Display a default user icon if no image is available -->
                            <i class="fa fa-user"></i>
                            @endif

                            Account Details</a>
                        <a class="nav-link " id="orders-nav" data-toggle="pill" href="#orders-tab" role="tab"><i
                                class="fa fa-shopping-bag"></i>Orders</a>
                        <a class="nav-link" id="payment-nav" data-toggle="pill" href="#payment-tab" role="tab"><i
                                class="fa fa-credit-card"></i>Payment Method</a>
                        <a class="nav-link" id="address-nav" data-toggle="pill" href="#address-tab" role="tab"><i
                                class="fa fa-map-marker-alt"></i>address</a>
                        <a class="nav-link" href="{{ route('Userlogout') }}"><i class="fa fa-sign-out-alt"></i>Logout</a>
                    </div>
                </div>
                <div class="col-md-9">
                    @if (session('success'))
                        <div class="alert alert-success alert-dismissible" role="alert">
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                            {{ session('success') }}
                        </div>
                    @endif
                    <div class="tab-content">
                        <div class="tab-pane fade" id="orders-tab" role="tabpanel" aria-labelledby="orders-nav">
                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead class="thead-dark">
                                        <tr>
                                            <th>No</th>
                                            <th>Product</th>
                                            <th>Date</th>
                                            <th>Price</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @php
                                            $i = 1; // Start numbering based on current pagination page
                                        @endphp
                                        @foreach ($orders as $order)
                                            @foreach ($order->items as $key => $item)
                                            <tr>
                                                <td>{{ $i++ }}</td>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->created_at->format('d-M-Y') }}</td>
                                                <td>₹{{ $item->price }}</td>
                                            
                                                <td>
                                                    <a href="{{ route('orders', $order->id) }}">
                                                        <button class="btn">View</button>
                                                    </a>
                                                </td>
                                            </tr>
                                            @endforeach
                                            @endforeach
                                            
                                        </tbody>
                                </table>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="payment-tab" role="tabpanel" aria-labelledby="payment-nav">
                            <h4>Payment Method</h4>
                           <ul>
                               {{-- @dd($orders)  --}}
                            @foreach ($orders->unique('payment_method') as $payment)
                            <li>{{$payment->payment_method}}</li>
                            @endforeach
                           </ul>
                        </div>
                        <div class="tab-pane fade" id="address-tab" role="tabpanel" aria-labelledby="address-nav">
                            <h4>Address</h4>
                            @if ($orders ?? '')
                            <div class="row">
                                @foreach ($orders as $order)
                                {{-- @dd($orders) --}}
                                    @foreach ($order->addresses as $addresses)

                                        
                                        @if ($addresses->address_type == 'billing_address')
                                            <div class="col-md-6">
                                                <h5>{{$addresses->address_type}}</h5>
                                                <p>{{$addresses->pincode}},</p>
                                                <p>{{$addresses->city}},</p>
                                                <p>{{$addresses->state}},</p>
                                                <p>{{$addresses->country}},</p>
                                                <p>{{$addresses->phone}}</p>
                                                
                                            </div>
                                        @endif
                                        @if ($addresses->address_type == 'shipping_address')
                                            <div class="col-md-6">
                                                <h5>{{$addresses->address_type}}</h5>
                                                <p>{{$addresses->pincode}},</p>
                                                <p>{{$addresses->city}},</p>
                                                <p>{{$addresses->state}},</p>
                                                <p>{{$addresses->country}},</p>
                                                <p>{{$addresses->phone}}</p>
                                                
                                            </div>
                                        @endif
                                    @endforeach
                                @endforeach
                            </div>
                                @else
                                <div class="row">
                                    @foreach ($orders as $order)
                                        @foreach ($order->addresses as $addresses)
                                            
                                            @if ($addresses->address_type == 'billing_address')
                                                <div class="col-md-6">
                                                    <h5>{{$addresses->address_type}}</h5>
                                                    <p>{{$addresses->pincode}},</p>
                                                    <p>{{$addresses->city}},</p>
                                                    <p>{{$addresses->state}},</p>
                                                    <p>{{$addresses->country}},</p>
                                                    <p>{{$addresses->phone}}</p>
                                                    
                                                </div>
                                            @endif
                                            @if ($addresses->address_type == 'shipping_address')
                                                <div class="col-md-6">
                                                    <h5>{{$addresses->address_type}}</h5>
                                                    <p>{{$addresses->pincode}},</p>
                                                    <p>{{$addresses->city}},</p>
                                                    <p>{{$addresses->state}},</p>
                                                    <p>{{$addresses->country}},</p>
                                                    <p>{{$addresses->phone}}</p>
                                                    
                                                </div>
                                            @endif
                                        @endforeach
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="tab-pane fade show active" id="account-tab" role="tabpanel"
                            aria-labelledby="account-nav">
                            <form action="{{ route('userProfileUpdate') }}" method="post">
                                @csrf
                                <h4>Account Details</h4>
                                <div class="row">
                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="{{ Auth::user()->name }}"
                                            value="{{ Auth::user()->name }}" name="name">
                                        @error('name')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-6">
                                        <input class="form-control" type="tel" placeholder="{{ Auth::user()->phone }}"
                                            value="{{Auth::user()->phone }}" name="phone">
                                        @error('phone')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>

                                    <div class="col-md-6">
                                        <input class="form-control" type="text" placeholder="{{ Auth::user()->email }}"
                                            value="{{ Auth::user()->email }}" name="email">
                                        @error('email')
                                            <span class="text-danger">{{ $message }}</span>
                                        @enderror
                                    </div>
                                    <div class="col-md-12">
                                        <button class="btn">Update Account</button>
                                        <br><br>
                                    </div>
                            </form>
                        </div>
                        <h4>Password change</h4>

                        <form action="{{ route('changePass') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-12">
                                    <input class="form-control" type="password" placeholder="Current Password"
                                        name="current_pass">
                                    @error('current_pass')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="password" placeholder="New Password"
                                        name="new_pass">
                                    @error('new_pass')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input class="form-control" type="password" placeholder="Confirm Password"
                                        name="con_pass">
                                    @error('con_pass')
                                        <span class="text-danger">{{ $message }}</span>
                                    @enderror
                                </div>
                                <div class="col-md-12">
                                    <button class="btn">Save Changes</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </div>
    <!-- My Account End -->
@endsection
