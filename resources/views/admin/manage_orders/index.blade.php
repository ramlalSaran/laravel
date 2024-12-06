@extends('admin.layouts.admin-layout')
@section('title', 'Order Table')
@section('content')

    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Orders Menage</h1>
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('dashboard.index') }}">Home</a></li>
                <li class="breadcrumb-item">Table</li>
                <li class="breadcrumb-item active" aria-current="page">Order Table</li>
            </ol>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                @endif
                <!-- Simple Tables -->
                <div class="card">
                    <div class="card-header py-3 d-flex flex-row align-items-center justify-content-between">
                        <h6 class="m-0 font-weight-bold text-primary">Order Data</h6>
                    </div>
                    <div class="table-responsive">
                        <table class="table align-items-center table-flush data-table">
                            <thead class="thead-light">
                                <tr>
                                    <th>Id</th>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Order Id</th>
                                    <th>User Id</th>
                                    <th>Address</th>
                                    <th>Address 2</th> <!-- Consider changing to Address 2 -->
                                    <th>City</th>
                                    <th>State</th>
                                    <th>Country</th>
                                    <th>PinCode</th>
                                    <th>Coupon</th>
                                    <th>Coupon Discount</th>
                                    <th>Shipping Cost</th>
                                    <th>Total</th>
                                    <th>Payment Method</th>
                                    <th>Shipping Method</th>
                                    <th>Subtotal</th>
                                    <th>Action</th>
                                    <th>Invoice</th>
                                    <th>SendMail</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                    <div class="card-footer"></div>
                </div>
            </div>
        </div>
        <!--Row-->

    </div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {  
        var table = $('.data-table').DataTable({
            processing: true,
            serverSide: true,
            ajax: "{{ route('order') }}",
            columns: [
                { data: 'id', name: 'id' },
                { data: 'name', name: 'name' },
                { data: 'email', name: 'email' },
                { data: 'phone', name: 'phone' },
                { data: 'order_increament_id', name: 'order_increament_id' }, // Correct this if needed
                { data: 'user_id', name: 'user_id' },
                { data: 'address', name: 'address' },
                { data: 'address_2', name: 'address_2' }, // Changed to underscore
                { data: 'city', name: 'city' },
                { data: 'state', name: 'state' },
                { data: 'country', name: 'country' },
                { data: 'pincode', name: 'pincode' },
                { data: 'coupon', name: 'coupon' },
                { data: 'coupon_discount', name: 'coupon_discount' },
                { data: 'shipping_cost', name: 'shipping_cost' }, // Ensure this matches your DB
                { data: 'total', name: 'total' },
                { data: 'payment_method', name: 'payment_method' },
                { data: 'shipping_method', name: 'shipping_method' },
                { data: 'sub_total', name: 'sub_total' },
                { data: 'show', name: 'show' },
                { data: 'invoice', name: 'invoice' },
                { data: 'SendMail', name: 'SendMail' },
            ]
        });
    });
</script>
@endsection
