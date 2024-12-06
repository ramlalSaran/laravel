@extends('admin.layouts.admin-layout')
@section('title', 'Order Show')
@section('content')

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Information</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active" aria-current="page">Show Order</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card">
                    <div class="card-header">
                        <a href="{{ route('order') }}" class="btn btn-primary float-right">Order List</a>
                    </div>

                    <div class="card-body">
                        <div class="row">
                            <div class="col-md-6">
                                <h3 class="text-black">Order Information</h3>
                                <hr>
                                <h4><strong>Order ID:</strong> {{ $order->order_increament_id }}</h4>
                                <h4><strong>Order Date:</strong> {{ $order->created_at->format('d-M-Y') }}</h4>
                            </div>
                            <div class="col-md-6">
                                <h3 class="text-black">Account Information</h3>
                                <hr>
                                <h4><strong>Customer Name: </strong> {{ $order->name }}</h4>
                                <h4><strong>Email: </strong> {{ $order->email }}</h4>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3 class="text-black font-weight-bold">Address Information</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Billing Address</h4>
                                        <p><strong>City:</strong> {{ $order->city }}</p>
                                        <p><strong>State:</strong> {{ $order->state }}</p>
                                        <p><strong>Country:</strong> {{ $order->country }}</p>
                                        <p><strong>PIN Code:</strong> {{ $order->pincode }}</p>
                                        <p><strong>Address:</strong> {{ $order->address }}</p>
                                        <p><strong>Address 2:</strong> {{ $order->address_2 }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Shipping Address</h4>
                                        <p><strong>City:</strong> {{ $order->city }}</p>
                                        <p><strong>State:</strong> {{ $order->state }}</p>
                                        <p><strong>Country:</strong> {{ $order->country }}</p>
                                        <p><strong>PIN Code:</strong> {{ $order->pincode }}</p>
                                        <p><strong>Address:</strong> {{ $order->address }}</p>
                                        <p><strong>Address 2:</strong> {{ $order->address_2 }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3>Payment & Shipping Method</h3>
                                <hr>
                                <div class="row">
                                    <div class="col-md-6">
                                        <h4>Payment Information</h4>
                                        <p><strong>Payment Method:</strong> {{ $order->payment_method }}</p>
                                    </div>
                                    <div class="col-md-6">
                                        <h4>Shipping Information</h4>
                                        <p><strong>Shipping Method:</strong> {{ $order->shipping_method }}</p>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3>Item Ordered</h3>
                                <hr>
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead>
                                            <tr>
                                                <th>Name</th>
                                                <th>SKU</th>
                                                <th>Price</th>
                                                <th>Qty</th>
                                                <th>Row Total</th>
                                                <th>Custom Option</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            {{-- Uncomment below to display items --}}
                                            @foreach ($order->items as $item)
                                            {{-- @dd($item); --}}
                                            <tr>
                                                <td>{{ $item->name }}</td>
                                                <td>{{ $item->sku }}</td>
                                                <td>{{ number_format($item->price, 2) }}</td>
                                                <td>{{ $item->qty }}</td>
                                                <td>{{ number_format($item->row_total, 2) }}</td>
                                                <td>{{ json_decode($item->coustom_option) }}</td>
                                            </tr>
                                        @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3>Order Total</h3>
                                <hr>
                                <table class="table table-bordered">
                                    <tbody>
                                        <tr>
                                            <th>SubTotal:</th>
                                            <td>{{ number_format($order->sub_total, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Coupon:</th>
                                            <td>{{ $order->coupon }}</td>
                                        </tr>
                                        <tr>
                                            <th>Coupon Discount:</th>
                                            <td>-{{ number_format($order->coupon_discount, 2) }}</td>
                                        </tr>
                                     
                                        <tr>
                                            <th>Shipping Cost:</th>
                                            <td>+{{ number_format($order->shipping_cost, 2) }}</td>
                                        </tr>
                                        <tr>
                                            <th>Total:</th>
                                            <td>{{ number_format($order->total, 2) }}</td>
                                        </tr>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div><!-- /.card-body -->
                </div><!-- /.card -->
            </div><!-- /.col -->
        </div>
    </div>

@endsection
