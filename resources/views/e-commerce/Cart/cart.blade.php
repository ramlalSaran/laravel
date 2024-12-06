@extends('e-commerce.layouts.layout')

@section('section')
<div class="breadcrumb-wrap">
    <div class="container-fluid">
        <ul class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
            <li class="breadcrumb-item"><a href="">Products</a></li>
            <li class="breadcrumb-item active">Cart</li>
        </ul>
    </div>
</div>

<div class="cart-page">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                @if (session('success'))
                    <div class="alert alert-success alert-dismissible" role="alert">
                        <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                        {{ session('success') }}
                    </div>
                @endif
                @if (session('Outstock'))
                        <p class="text-danger font-weight-bold">{{ session('Outstock') }}</p>
                @endif
                <div class="cart-page-inner">
                    <div class="table-responsive">
                        <table class="table table-bordered">
                            <thead class="thead-dark">
                                <tr>
                                    <th>Product</th>
                                    <th>Stock</th>
                                    <th>Price</th>
                                    <th>Quantity</th>
                                    <th>Total</th>
                                    <th>Remove</th>
                                </tr>
                            </thead>
                            <tbody class="align-middle">
                                @if ($cart_items->isNotEmpty())
                                    @php
                                        $subtotal = 0;
                                        $row_total = 0;
                                        $shipping_cost = 5;
                                        $totalProducts = 0;
                                    @endphp
                                    {{-- @dd($cart_items) --}}
                                    @foreach ($cart_items as $cartItem)
                                        @php
                                            $subtotal += $cartItem->price;
                                            $row_total +=$cartItem->row_total;
                                            $totalProducts += $cartItem->qty;
                                        @endphp
                                        <tr>
                                            <td>
                                                <div class="img">
                                                    <a href="#">
                                                        <img src="{{ optional($cartItem->product)->getFirstMediaUrl('thumb_image') ?? 'default-image-url.png' }}" alt="Image">
                                                    </a>
                                                    <p>{{ $cartItem->name }}</p>
                                                </div>
                                            </td>
                                            <td  class="{{ $cartItem->product->stock_status == 1 ? 'text-success' : ($cartItem->product->stock_status == 2 ? 'text-warning' : 'text-danger') }}">
                                                {{ $cartItem->product->stock_status == 1 ? 'In Stock' : ($cartItem->product->stock_status == 2 ? 'Few in Stock' : 'Out of Stock') }}
                                            </td>

                                            <td>₹{{ $cartItem->price }}</td>
                                            <td>
                                                <form action="{{ route('QtyUpdate', $cartItem->id) }}" method="post" class="form">
                                                    @csrf
                                                    @method('put')
                                                    <input type="hidden" name="product_id" value="{{ $cartItem->product_id }}">
                                                    <input type="hidden" name="row_total" value="{{ $row_total }}">

                                                    <div class="quantity" style="display: flex; align-items: center;">
                                                        <div class="qty" style="display: flex; align-items: center;">
                                                            <button class="btn-minus" type="button" data-quote-item-id="{{ $cartItem->id }}"><i class="fa fa-minus"></i></button>
                                                            <input type="text" value="{{ $cartItem->qty }}" name="qty" class="qty-input" data-quote-item-id="{{ $cartItem->id }}" style="width: 50px; text-align: center; margin: 0 5px;">
                                                            <button class="btn-plus" type="button" data-quote-item-id="{{ $cartItem->id }}">
                                                                <i class="fa fa-plus"></i>
                                                            </button>
                                                        </div>
                                                        <button type="submit" class="button update-btn" style="margin-left: 10px; width: 100%; display: none;">Update</button>
                                                    </div>
                                                </form>
                                            </td>
                                            <td>₹{{ $cartItem->row_total }}</td>
                                            <td>
                                                <form action="{{ route('ItemDelete', $cartItem->id) }}" method="POST">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-link" aria-label="Remove item">
                                                        <i class="fa fa-trash"></i>
                                                    </button>
                                                </form>
                                            </td>
                                        </tr>
                                    @endforeach
                                    {{-- @dd($subtotal) --}}
                                @else
                                    <tr>
                                        <td colspan="6" class="text-danger">Cart Is Empty</td>
                                    </tr>
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="col-lg-4">
                <div class="cart-page-inner">
                    @if (session('error'))
                        <p class="text-danger font-weight-bold">{{ session('error') }}</p>
                    @endif
                    <div class="row">
                        <div class="col-md-12">
                            <div class="coupon">
                                <form action="{{ route('couponDiscount') }}" method="post">
                                    @csrf
                                        <input type="hidden" name="cart_id" value="{{ $cartItem->quote_id ?? '' }}">
                                        
                                        @if ($cartdata->coupon ?? '')                                    
                                        <input type="text" placeholder="Coupon Code" name="coupon_code" disabled value="{{ $cartdata->coupon ?? ''}}">
                                        <a href="{{route('remove_coupon',$cartdata->id)}}" ><button type="button">Remove code</button></a>
                                        @else
                                        <input type="text" placeholder="Coupon Code" name="coupon_code" >
                                        <button type="submit">Apply Code</button>
                                    @endif
                                </form>
                            </div>
                        </div>
                        @if ($cartdata !==null)
                            <div class="col-md-12">
                                <form action="{{ route('checkout')}}" >
                                    <div class="cart-summary">
                                        <div class="cart-content">
                                            <h1>Cart Summary</h1>                                         
                                            <p>Sub Total<span>₹{{ $cartdata->subtotal}}</span></p>
                                            <p>Coupon Discount<span>- ₹{{ $cartdata->coupon_discount ?? '0' }}</span></p>
                                            <h2>Grand Total<span>₹{{ $cartdata->total  }}</span></h2>
                                        </div>
                                        <div class="cart-btn">
                                            @if (Auth::user()) 
                                            {{-- <button type="submit">Update Cart</button> --}}
                                            <button type="submit">Checkout</button>
                                            @else
                                            <a href="{{route('login_form')}}"> <button type="button">First Login</button></a>
                                            @endif
                                        </div>
                                    </div>
                                </form>
                            </div>
                        @else
                            <td>Your Cart is Empty</td>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@section('script')
    <script>
        $(document).ready(function() {
            $('.btn-plus').click(function() {
                $(this).closest('form').find('button.update-btn').show();
            });

            $('.btn-minus').click(function() {
                const input = $(this).siblings('.qty-input');
                let qty = parseInt(input.val());
                if (qty > 1) {
                    input.val(qty - 1);
                    $(this).closest('form').find('button.update-btn').show();
                }
            });
        });
    </script>
@endsection
@endsection
