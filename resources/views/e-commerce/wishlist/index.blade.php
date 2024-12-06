@extends('e-commerce.layouts.layout')
@section('title', 'wishlist')
@section('section')

    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Wishlist</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Wishlist Start -->
    <div class="wishlist-page">
        <div class="container-fluid">
            <div class="wishlist-page-inner">
                <div class="row">
                    <div class="col-md-12">
                        @if (session('success'))
                            <div class="alert alert-success alert-dismissible" role="alert">
                                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                </button>
                                {{ session('success') }}
                            </div>
                        @endif
                        <div class="table-responsive">
                            <table class="table table-bordered">
                                <thead class="thead-dark">
                                    <tr>
                                        <th>Product</th>
                                        <th>Price</th>
                                        <th>Add to Cart</th>
                                        <th>QTY</th>
                                        <th>Remove</th>
                                    </tr>
                                </thead>
                                <tbody class="align-middle">
                                    @foreach ($wishListItems as $item)
                                    <form action="{{route('CartStore')}}" method="post">
                                        @csrf
                                        <input type="hidden" name="product_id" value="{{ $item->product_id }}">
                                        <tr>
                                            <td>
                                                <div class="img">
                                                    <a href="#">
                                                        <img src="{{ $item->product->getFirstMediaUrl('thumb_image') }}"
                                                            alt="Image">
                                                    </a>
                                                    <p>{{ $item->Product->name }}</p>
                                                </div>
                                            </td>
                                            <td>{!! displayPrice($item->Product) !!}</td>
                                            <td>
                                                <div class="qty">
                                                    {{-- <button class="btn-minus"><i class="fa fa-minus"></i></button> --}}
                                                    <input type="text" value="1" name="qty">
                                                    {{-- <button class="btn-plus"><i class="fa fa-plus"></i></button> --}}
                                                </div>
                                            </td>
                                            <td><button class="btn-cart" type="submit">Add to Cart</button></td>
                                        </form>
                                        <form action="{{route('wishlistDelete',$item->product_id)}}" method="post">
                                            @csrf
                                            @method('delete')
                                            <td><button type="submit"><i class="fa fa-trash"></i></button></td>
                                        </form>
                                        </tr>
                                    @endforeach


                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wishlist End -->
@endsection
