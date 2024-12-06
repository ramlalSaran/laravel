@extends('e-commerce.layouts.layout')
@section('section')
    <!-- Breadcrumb Start -->
    <div class="breadcrumb-wrap">
        <div class="container-fluid">
            <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="{{ route('home') }}">Home</a></li>
                <li class="breadcrumb-item"><a href="#">Products</a></li>
                <li class="breadcrumb-item active">Product Detail</li>
            </ul>
        </div>
    </div>
    <!-- Breadcrumb End -->

    <!-- Product Detail Start -->
    <div class="product-detail">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-8">
                    <div class="product-detail-top">
                        <div class="row align-items-center">
                            <div class="col-md-5">
                                <div class="product-slider-single normal-slider">
                                    <img src="{{ $productDetail->getFirstMediaUrl('thumb_image') }}" alt="Product Image"
                                        class="img-fluid">
                                    @foreach ($productDetail->getMedia('banner_image') as $banner)
                                        <div class="slider-nav-img">
                                            <img src="{{ $banner->getUrl() }}" alt="Product Image" class="img-fluid">
                                        </div>
                                    @endforeach
                                </div>
                                <div class="product-slider-single-nav normal-slider">
                                    @foreach ($productDetail->getMedia('banner_image') as $banner)
                                        <div class="slider-nav-img">
                                            <img src="{{ $banner->getUrl() }}" alt="Product Image" class="img-fluid">
                                        </div>
                                    @endforeach
                                </div>
                            </div>
                            <div class="col-md-7">
                                <div class="product-content">
                                    <div class="title">
                                        <h2 class="{{ $productDetail->stock_status == 1 ? 'text-success' : ($productDetail->stock_status == 2 ? 'text-warning' : 'text-danger') }}">
                                            {{ $productDetail->stock_status == 1 ? 'In Stock' : ($productDetail->stock_status == 2 ? 'Few in Stock' : 'Out of Stock') }}
                                        </h2>
                                        <h2>{{ $productDetail->name }}</h2>
                                    </div>
                                    {{-- if $avgRating variable in the data --}}
                                    @if ($avgRating)
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= round($avgRating))
                                                <i class="fa fa-star" style="color: rgb(255, 94, 0);"></i>
                                            @else
                                                <i class="fa fa-star" style="color: lightgray;"></i>
                                            @endif
                                        @endfor
                                
                                    @else
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star" style="color: lightgray;"></i>
                                        @endfor
                                    @endif

                                    {{-- cart data store with product detail --}}
                                    <form action="{{ route('CartStore') }}" method="POST">
                                        @csrf
                                        <div class="price">
                                            <input type="hidden" name="product_id" value="{{ $productDetail->id }}">
                                            <h4 class="h4 font-weight-bold ">Price: </h4>
                                            {!! displayPrice($productDetail) !!}
                                        </div>
                                        <div class="quantity">
                                            <h4>Quantity:</h4>
                                            <div class="qty">
                                                <button class="btn-minus" type="button"><i class="fa fa-minus"></i></button>
                                                <input type="text" value="1" name="qty">
                                                <button class="btn-plus" type="button"><i class="fa fa-plus"></i></button>
                                            </div>
                                        </div>

                                         {{-- Get attribute and attribute values  --}}
                                        @foreach ($productDetail->productAttributes->groupBy('attribute_id') as $attributeId => $productAttributes)
                                            <div class="p-size">
                                                @php
                                                    $attributeName = $productAttributes->first()->attribute->name;
                                                    @endphp
                                                    {{-- @dd($attributeName) --}}

                                                <h4>{{ $attributeName }}:</h4>
                                                <div class="btn-group btn-group-toggle" data-toggle="buttons">
                                                    @foreach ($productAttributes as $productAttribute)
                                                        {{-- @dd($productAttribute);  --}}
                                                        <label class="btn btn-secondary">
                                                            <input type="radio" name="attribute_value[{{ $productAttribute->attribute->name }}]" id="{{ $productAttribute->id }}" value="{{ $productAttribute->attributeValue->name }}" autocomplete="off">
                                                            {{ $productAttribute->attributeValue->name }}
                                                        </label>
                                                    @endforeach
                                                </div>
                                                <br>
                                            </div>
                                        @endforeach
                                        <div class="action">
                                            <button class="btn btn-primary" type="submit"><i class="fa fa-shopping-cart"></i>Add to Cart</button>
                                            <a class="btn btn-success" href="#"><i class="fa fa-shopping-bag"></i> Buy Now</a>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row product-detail-bottom">
                        <div class="col-lg-12">
                            <ul class="nav nav-pills nav-justified">
                                <li class="nav-item">
                                    <a class="nav-link active" data-toggle="pill" href="#description">Description</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill" href="#specification">Specification</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" data-toggle="pill"
                                        href="#reviews">Reviews({{ count($reviews) }})</a>
                                </li>
                            </ul>

                            <div class="tab-content">
                                <div id="description" class="container tab-pane active">
                                    <h4>Product description</h4>
                                    <p>
                                        {!! $productDetail->description !!}
                                    </p>
                                </div>
                                <div id="specification" class="container tab-pane fade">
                                    <h4>Product specification</h4>
                                    <ul>
                                        <li>{!! $productDetail->short_description !!}</li>

                                    </ul>
                                </div>
                                <div id="reviews" class="container tab-pane fade">
                                    @foreach ($reviews as $_review)
                                        <div class="reviews-submitted">
                                            <div class="reviewer">{{ $_review->name }} -
                                                <span>{{ $_review->created_at->format('d M, Y') }}</span>
                                            </div>
                                            <div class="ratting">
                                                @for ($i = 5; $i > $_review->rating; $i--)
                                                    <i class="fa fa-star"></i>
                                                @endfor
                                            </div>
                                            <p>
                                                {{ $_review->review }}
                                            </p>
                                        </div>
                                    @endforeach

                                    <div class="reviews-submit">
                                        <h4>Give your Review:</h4>
                                        <form method="POST" action="{{ route('sendReview') }}">
                                            @csrf
                                            <div class="rating">
                                                <input type="radio" id="star5" name="rating" value="5">
                                                <label for="star5" class="far fa-star"></label>
                                                
                                                <input type="radio" id="star4" name="rating" value="4">
                                                <label for="star4" class="far fa-star"></label>

                                                <input type="radio" id="star3" name="rating" value="3">
                                                <label for="star3" class="far fa-star"></label>

                                                <input type="radio" id="star2" name="rating" value="2">
                                                <label for="star2" class="far fa-star"></label>

                                                <input type="radio" id="star1" name="rating" value="1">
                                                <label for="star1" class="far fa-star"></label>
                                            </div>
                                            <div class="row form">
                                                <div class="col-sm-6">
                                                    <input type="hidden" name="product_id" value="{{ $productDetail->id }}">
                                                    <input type="text" placeholder="Name" name="name">
                                                </div>
                                                <div class="col-sm-6">
                                                    <input type="email" placeholder="Email" name="email">
                                                </div>
                                                <div class="col-sm-12">
                                                    <textarea placeholder="Review" name="review"></textarea>
                                                </div>
                                                <div class="col-sm-12">
                                                    <button type="submit">Submit</button>
                                                </div>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="product">
                        <div class="section-header">
                            <h1>Related Products</h1>
                        </div>
                        <div class="row align-items-center product-slider product-slider-3">
                            @foreach ($relatedProducts as $Featured_product)
                                <div class="col-lg-3">
                                    <div class="product-item">
                                        <div class="product-title">
                                            <a href="#">{{ $Featured_product->name }}</a>
                                            <div class="ratting">
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                                <i class="fa fa-star"></i>
                                            </div>
                                        </div>
                                        <div class="product-image">
                                            <a href="#">
                                                <img src="{{ $Featured_product->getFirstMediaUrl('thumb_image') }}" alt="Product Image">
                                            </a>
                                            <div class="product-action">
                                                <a href="#"><i class="fa fa-cart-plus"></i></a>
                                                <a href="{{ route('wishlistPost', $Featured_product->id) }}"><i class="fa fa-heart"></i></a>
                                                <a href="{{ route('productdetail', $Featured_product->url_key) }}"><i class="fa fa-search"></i></a>
                                            </div>
                                        </div>
                                        <div class="product-price">
                                            <h3 style="font-size:10px; font-weight:bold;">{!! displayPrice($Featured_product) !!}</h3>
                                            <a class="btn btn-primary"
                                                href="{{ route('productdetail', $Featured_product->url_key) }}"><i
                                                    class="fa fa-shopping-cart"></i> Buy Now</a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                    
                            {{-- Agar sirf ek product hai, toh use duplicate kar dete hain --}}
                            @if ($relatedProducts->count() <= 2)
                            {{-- @dd('ssd'); --}}
                                @foreach ($relatedProducts as $Featured_product)
                                    <div class="col-lg-3">
                                        <div class="product-item">
                                            <div class="product-title">
                                                <a href="#">{{ $Featured_product->name }}</a>
                                                <div class="ratting">
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                    <i class="fa fa-star"></i>
                                                </div>
                                            </div>
                                            <div class="product-image">
                                                <a href="#">
                                                    <img src="{{ $Featured_product->getFirstMediaUrl('thumb_image') }}" alt="Product Image">
                                                </a>
                                                <div class="product-action">
                                                    <a href="#"><i class="fa fa-cart-plus"></i></a>
                                                    <a href="{{ route('wishlistPost', $Featured_product->id) }}"><i class="fa fa-heart"></i></a>
                                                    <a href="{{ route('productdetail', $Featured_product->url_key) }}"><i class="fa fa-search"></i></a>
                                                </div>
                                            </div>
                                            <div class="product-price">
                                                <h3 style="font-size:10px; font-weight:bold;">{!! displayPrice($Featured_product) !!}</h3>
                                                <a class="btn btn-primary"
                                                    href="{{ route('productdetail', $Featured_product->url_key) }}"><i
                                                        class="fa fa-shopping-cart"></i> Buy Now</a>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                    
                </div>

                <!-- Side Bar Start -->
                <div class="col-lg-4 sidebar">
                    <div class="sidebar-widget category">
                        <h2 class="title">Category</h2>
                        <nav class="navbar bg-light">
                            <ul class="navbar-nav">
                                <li class="nav-item">
                                    <a class="nav-link" href="{{route('home')}}"><i class="fa fa-home"></i>Home</a>
                                </li>
                                @foreach (categories() as $category)
                                <li class="nav-item">
                                    <a class="nav-link"href="{{ route('CategotyPage',$category->url_key) }}"><i class="fas fa-tags"></i>{{ $category->name }}</a>
                                </li>
                                @endforeach
                            </ul>
                        </nav>
                    </div>

                    <div class="sidebar-widget widget-slider">
                        <div class="sidebar-slider normal-slider">
                            @foreach (Featured_products() as $Featured_product)
                                <div class="product-item">
                                    <div class="product-title">
                                        <a href="#">{{ $Featured_product->name }}</a>
                                        <div class="ratting">
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                            <i class="fa fa-star"></i>
                                        </div>
                                    </div>
                                    <div class="product-image">
                                        <a href="#">
                                            <img src="{{ $Featured_product->getFirstMediaUrl('thumb_image') }}"
                                                alt="Product Image">
                                        </a>
                                        <div class="product-action">
                                            <a href="#"><i class="fa fa-cart-plus"></i></a>
                                            <a href="{{ route('wishlistPost', $Featured_product->id) }}"><i
                                                    class="fa fa-heart"></i></a>
                                            <a href="{{ route('productdetail', $Featured_product->url_key) }}"><i
                                                    class="fa fa-search"></i></a>
                                        </div>
                                    </div>
                                    <div class="product-price">
                                        <h3 style="font-size:10px; font-weight:bold;">{!! displayPrice($Featured_product) !!}</h3>
                                        <a class="btn" href="{{ route('productdetail', $Featured_product->url_key) }}"><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="sidebar-widget brands">
                        <h2 class="title">Our Brands</h2>
                        <ul>
                            <li><a href="#">Nulla </a><span>(45)</span></li>
                            <li><a href="#">Curabitur </a><span>(34)</span></li>
                            <li><a href="#">Nunc </a><span>(67)</span></li>
                            <li><a href="#">Ullamcorper</a><span>(74)</span></li>
                            <li><a href="#">Fusce </a><span>(89)</span></li>
                            <li><a href="#">Sagittis</a><span>(28)</span></li>
                        </ul>
                    </div>

                    <div class="sidebar-widget tag">
                        <h2 class="title">Tags Cloud</h2>
                        @foreach (Featured_products() as $Featured_product)
                            <a href="">{{ $Featured_product->meta_tag }}</a>
                        @endforeach

                    </div>
                </div>
                <!-- Side Bar End -->
            </div>
        </div>
    </div>
    <!-- Product Detail End -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-1.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-2.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-3.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-4.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-5.png') }}" alt=""></div>
                <div class="brand-item"><img src="{{ asset('e-web_assets/img/brand-6.png') }}" alt=""></div>
            </div>
        </div>
    </div>
    <!-- Brand End -->

@endsection
