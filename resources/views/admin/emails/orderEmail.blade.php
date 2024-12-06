<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Product</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
            line-height: 1.6;
        }
        .container-fluid {
            max-width: 1200px;
            margin: auto;
        }
        .text-black {
            color: #333;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background: #f2f2f2;
        }
        hr {
            border: 1px solid #ccc;
        }
    </style>
</head>
<body>
    <div class="container-fluid" id="container-wrapper">
        <div class="d-sm-flex align-items-center justify-content-between mb-4">
            <h1 class="h3 mb-0 text-gray-800">Order Information</h1>
        </div>

        <div class="row">
            <div class="col-lg-12 mb-4">
                <div class="card" style="border: 1px solid #ddd; border-radius: 5px; overflow: hidden;">
                    <div class="card-header" style="background-color: #f8f9fa; padding: 10px;">
                        <a href="{{ route('userProfile') }}" class="btn btn-primary float-right" style="margin-left: 10px;">Back Orders</a>
                        <a href="{{ route('generateInvoice', $order->id) }}" class="btn btn-primary float-right">Invoice</a>
                    </div>

                    <div class="card-body" style="padding: 20px;">
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
                                <h4><strong>Customer Name:</strong> {{ $order->name }}</h4>
                                <h4><strong>Email:</strong> {{ $order->email }}</h4>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-md-12">
                                <h3 class="text-black font-weight-bold">Address Information</h3>
                                <hr>
                                <div class="row">
                                    @foreach ($order->addresses as $address)
                                        @if ($address->order_id == $order->id)
                                            @if ($address->address_type == 'billing_address')
                                                <div class="col-md-6">
                                                    <h4>Billing Address</h4>
                                                    <p><strong>City:</strong> {{ $address->city }}</p>
                                                    <p><strong>State:</strong> {{ $address->state }}</p>
                                                    <p><strong>Country:</strong> {{ $address->country }}</p>
                                                    <p><strong>PIN Code:</strong> {{ $address->pincode }}</p>
                                                    <p><strong>Address:</strong> {{ $address->address }}</p>
                                                    <p><strong>Address 2:</strong> {{ $address->address_2 }}</p>
                                                </div>
                                            @elseif ($address->address_type == 'shipping_address')
                                                <div class="col-md-6">
                                                    <h4>Shipping Address</h4>
                                                    <p><strong>City:</strong> {{ $address->city }}</p>
                                                    <p><strong>State:</strong> {{ $address->state }}</p>
                                                    <p><strong>Country:</strong> {{ $address->country }}</p>
                                                    <p><strong>PIN Code:</strong> {{ $address->pincode }}</p>
                                                    <p><strong>Address:</strong> {{ $address->address }}</p>
                                                    <p><strong>Address 2:</strong> {{ $address->address_2 }}</p>
                                                </div>
                                            @endif
                                        @endif
                                    @endforeach
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
                                    <table class="table">
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
                                            @foreach ($order->items as $item)
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
                                <table class="table">
                                    <tbody>
                                        <tr>
                                            <th>Products SubTotal:</th>
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
</body>
</html>
