@extends('e-commerce.layouts.layout')
@section('section')
    <div class="header">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-3">
                    <nav class="navbar bg-light">
                        <ul class="navbar-nav">
                            <li class="nav-item">
                                <a class="nav-link" href="{{route('home')}}"><i class="fa fa-home"></i>Home</a>
                            </li>
                            @foreach (categories() as $category)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('CategotyPage', $category->url_key) }}"><i class="fas fa-tags"></i>{{ $category->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>
                <div class="col-md-6">
                    <div class="header-slider normal-slider">
                        @foreach ($sliders as $slider)
                            <div class="header-slider-item">
                                <img src="{{ $slider->getFirstMediaUrl('image') }}" alt="Slider Image" />
                                {{-- <div class="header-slider-caption">
                            <p>{{$slider->title}}</p>
                
                        </div> --}}
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="header-img">
                        <div class="img-item">
                            <img src="{{ asset('e-web_assets/img/category-1.jpg') }}" />
                            <a class="img-text" href="">
                                <p>Some text goes here that describes the image</p>
                            </a>
                        </div>
                        <div class="img-item">
                            <img src="{{ asset('e-web_assets/img/category-2.jpg') }}" />
                            <a class="img-text" href="">
                                <p>Some text goes here that describes the image</p>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Main Slider End -->

    <!-- Brand Start -->
    <div class="brand">
        <div class="container-fluid">
            <div class="brand-slider">
                @foreach (Brands() as $brand)
                <div class="brand-item"><img src="{{ asset('storage/'. $brand->brand_image) }}" alt=""></div>
                    
                @endforeach

            </div>
        </div>
    </div>
    <!-- Brand End -->

    <!-- Feature Start-->
    <div class="feature">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fab fa-cc-mastercard"></i>
                        <h2>Secure Payment</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur elit
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-truck"></i>
                        <h2>Worldwide Delivery</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur elit
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-sync-alt"></i>
                        <h2>90 Days Return</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur elit
                        </p>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 feature-col">
                    <div class="feature-content">
                        <i class="fa fa-comments"></i>
                        <h2>24/7 Support</h2>
                        <p>
                            Lorem ipsum dolor sit amet consectetur elit
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Feature End-->

    <!-- Category Start-->
    {{-- <div class="container-fluid pt-5">
    <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="">Categories</span></h2>
    <div class="row px-xl-5 pb-3">
        
        @foreach (AllCategories() as $category)        
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
                <a class="text-decoration-none" href="{{route('CategotyPage',$category->url_key)}}">
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px;">
                            <img class="img-fluid" src="{{$category->getFirstMediaUrl('category_image')}}" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6>{{$category->name}}</h6>
                            <strong class="text-body">All Products:{{count($category->products)}}</strong>
                        </div>
                    </div>
                </a>
            </div>
            @endforeach
        </div>
</div> --}}
    <!-- Category End-->

    <!-- Call to Action Start -->
    <div class="call-to-action">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1>call us for any queries</h1>
                </div>
                <div class="col-md-6">
                    <a href="tel:91+ 9376136511">+{{$user->phone}}</a>
                </div>
            </div>
        </div>
    </div>
    <!-- Call to Action End -->



    <div class="featured-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Featured Product</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                {{-- this start Featured products and Featured_products Function a helper function  --}}
                @foreach (Featured_products() as $product)
                    <div class="col-lg-3">
                        <div class="product-item">
                            <div class="product-title">
                                <a href="{{ route('productdetail', $product->url_key) }}">{{ $product->name }}</a>
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
                                    <img src="{{ $product->getFirstMediaUrl('thumb_image') }}" alt="Product Image">
                                </a>
                                <div class="product-action">
                                    <a href="#"><i class="fa fa-cart-plus"></i></a>
                                    @if (Auth::user())

                                    <a href="{{ route('wishlistPost', $product->id) }}" ><i class="fa fa-heart"></i></a>
                                    @else
                                    <a href="{{ route('User_loginPost') }}" ><i class="fa fa-heart"></i></a>
                                    @endif
                                    <a href="{{ route('productdetail', $product->url_key) }}"><i
                                            class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <h3 style="font-size:12px; font-weight:bold;"> {!! displayPrice($product) !!}</h3>
                                <a class="btn" href="{{ route('productdetail', $product->url_key) }}"><i
                                        class="fa fa-shopping-cart"></i>Buy Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach

            </div>
        </div>
    </div>
    <!-- Featured Product End -->

    <!-- Newsletter Start -->
    <div class="newsletter">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-6">
                    <h1>Subscribe Our Newsletter</h1>
                </div>
                <div class="col-md-6">
                    <div class="form">
                        <form action="{{route('newsletter')}}" method="post">
                            @csrf
                            <input type="email" name="email" placeholder="Your email here">
                            @error('email')
                                <span>{{$message}}</span>
                            @enderror
                            <button style="top: 5px;">Submit</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Newsletter End -->



    <!-- Recent Product Start -->
    
    <div class="recent-product product">
        <div class="container-fluid">
            <div class="section-header">
                <h1>Recent Product</h1>
            </div>
            <div class="row align-items-center product-slider product-slider-4">
                {{-- this start Recent Products and Recent_products Function a helper function  
                --}}
                @foreach (Recent_products() as $rcntProduct)
                    <div class="col-lg-3">
                        <div class="product-item">
                            <div class="product-title">
                                <a href="#">{{ $rcntProduct->name }}</a>
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
                                    <img src="{{ $rcntProduct->getFirstMediaUrl('thumb_image') }}" alt="Product Image">
                                </a>
                                <div class="product-action">
                                    <a href="#"><i class="fa fa-cart-plus"></i></a>
                                    <a href="{{ route('wishlistPost', $rcntProduct->id) }}"><i class="fa fa-heart"></i></a>
                                    <a href="{{ route('productdetail', $rcntProduct->url_key) }}"><i
                                            class="fa fa-search"></i></a>
                                </div>
                            </div>
                            <div class="product-price">
                                <h3 style="font-size:12px; font-weight:bold;">{!! displayPrice($rcntProduct) !!}</h3>
                                <a class="btn" href="{{ route('productdetail', $rcntProduct->url_key) }}"><i
                                        class="fa fa-shopping-cart"></i>Buy Now</a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- Recent Product End -->


    <!-- Review Start -->
    <div class="review">
        <div class="container-fluid">
            <div class="row align-items-center review-slider normal-slider">
                @foreach ($reviews as $review)
                <div class="col-md-6">
                    <div class="review-slider-item">
                        <div class="review-img" style="text-align: center;">
                            <i class="fa fa-user" style="font-size: 100px; color: gray;"></i>
                        </div>
                        <div class="review-text">
                            <h2>{{ $review->name }} </h2>
                            <p>Product Review - {{ Str::limit($review->Product->name, 25, '...')  }}
                            </p>
                            
                            <h3>{{ $review->email }}</h3>
                            <div class="ratting">
                                @for ($i = 1; $i <= 5; $i++)
                                    @if ($i <= $review->rating)
                                        <i class="fa fa-star" style="color: gold;"></i>
                                    @else
                                        <i class="fa fa-star" style="color: lightgray;"></i>
                                    @endif
                                @endfor
                                <p>{{ Str::limit($review->review, 25, '...') }}</p>

                            </div>
                            {{-- <p>{{ $review->comment }}</p> --}}
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
