@extends('e-commerce.layouts.layout')

@section('section')
<div class="product-view">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-8">
                <div class="row">
                    <div class="col-md-12">
                        <div class="product-view-top">
                            <form action="{{ route('catalog') }}" method="GET">
                                <div class="row">
                                    <div class="col-md-4">
                                        <div class="product-search">
                                            <input type="text" placeholder="Search" value="{{ request()->search }}" name="search">
                                            <button><i class="fa fa-search"></i></button>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-short">
                                            <div class="dropdown">
                                                <select name="order" id="order" class="custom-select" onchange="this.form.submit()">
                                                    <option value="ASC" {{ request('order') == 'ASC' ? 'selected' : '' }}>Newest</option>
                                                    <option value="DESC" {{ request('order') == 'DESC' ? 'selected' : '' }}>Oldest</option>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="product-price-range">
                                            <select name="price_range" id="price_range" class="custom-select" onchange="this.form.submit()">
                                                <option value="">--Select Price Range--</option>
                                                <option value="0-500" {{ request('price_range') == '0-500' ? 'selected' : '' }}>₹0 to ₹500</option>
                                                <option value="501-1000" {{ request('price_range') == '501-1000' ? 'selected' : '' }}>₹501 to ₹1000</option>
                                                <option value="1001-2000" {{ request('price_range') == '1001-2000' ? 'selected' : '' }}>₹1001 to ₹2000</option>
                                                <option value="2001-5000" {{ request('price_range') == '2001-5000' ? 'selected' : '' }}>₹2001 to ₹5000</option>
                                                <option value="5001-10000" {{ request('price_range') == '5001-10000' ? 'selected' : '' }}>₹5001 to ₹10000</option>
                                                <option value="10001-20000" {{ request('price_range') == '10001-20000' ? 'selected' : '' }}>₹10001 to ₹20000</option>
                                                <option value="20001-30000" {{ request('price_range') == '20001-30000' ? 'selected' : '' }}>₹20001 to ₹30000</option>
                                                <option value="30001-40000" {{ request('price_range') == '30001-40000' ? 'selected' : '' }}>₹30001 to ₹40000</option>
                                                <option value="40001-60000" {{ request('price_range') == '40001-60000' ? 'selected' : '' }}>₹40001 to ₹60000</option>
                                                <option value="60001-100000" {{ request('price_range') == '60001-100000' ? 'selected' : '' }}>₹60001 to ₹100000</option>
                                                <option value="100001-500000" {{ request('price_range') == '100001-500000' ? 'selected' : '' }}>₹00001 and Above</option>
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="row">
                    @foreach ($products as $product)
                        <div class="col-md-4">
                            <div class="product-item">
                                <div class="product-title text-break">
                                    <a href="{{ route('productdetail', $product->url_key) }}" class="h-6">{{ $product->name }}</a>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                    </div>
                                </div>
                                <div class="product-image">
                                    <a href="{{ route('productdetail', $product->url_key) }}">
                                        <img src="{{ $product->getFirstMediaUrl('thumb_image') }}" alt="{{ $product->name }}" class="mx-auto d-block">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="{{ route('wishlistPost', $product->id) }}"><i class="fa fa-heart"></i></a>
                                        <a href="{{ route('productdetail', $product->url_key) }}"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>
                                <div class="product-price">
                                    <h3 style="font-size:10px; font-weight:bold;">{!! displayPrice($product) !!}</h3>
                                    <a class="btn" href="{{ route('productdetail', $product->url_key) }}"><i class="fa fa-shopping-cart"></i>Buy Now</a>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                <!-- Pagination Start -->
                {{-- <div class="col-md-12">
                    {{ $products->links() }} <!-- Laravel's pagination links -->
                </div> --}}
                <!-- Pagination End -->
            </div>                

            <!-- Side Bar Start -->
            <div class="col-lg-4 sidebar">
                <div class="sidebar-widget category">
                    <h2 class="title">Category</h2>
                    <nav class="navbar bg-light">
                        <ul class="navbar-nav">
                            @foreach (categories() as $cat)
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('CategotyPage', $cat->url_key) }}"><i class="fas fa-tags"></i>{{ $cat->name }}</a>
                                </li>
                            @endforeach
                        </ul>
                    </nav>
                </div>

                <div class="sidebar-widget widget-slider">
                    <div class="sidebar-slider normal-slider">
                        @foreach (Recent_products() as $newProduct)
                            <div class="product-item">
                                <div class="product-title">
                                    <a href="#">{{ $newProduct->name }}</a>
                                    <div class="rating">
                                        @for ($i = 1; $i <= 5; $i++)
                                            <i class="fa fa-star"></i>
                                        @endfor
                                    </div>
                                </div>

                                <div class="product-image md-3">
                                    <a href="{{ route('productdetail', $newProduct->url_key) }}">
                                        <img src="{{ $newProduct->getFirstMediaUrl('thumb_image') }}" alt="{{ $newProduct->name }}">
                                    </a>
                                    <div class="product-action">
                                        <a href="#"><i class="fa fa-cart-plus"></i></a>
                                        <a href="{{ route('wishlistPost', $newProduct->id) }}"><i class="fa fa-heart"></i></a>
                                        <a href="{{ route('productdetail', $newProduct->url_key) }}"><i class="fa fa-search"></i></a>
                                    </div>
                                </div>

                                <div class="product-price">
                                    <h3 style="font-size:10px; font-weight:bold;">{!! displayPrice($newProduct) !!}</h3>
                                    <a class="btn" href="{{ route('productdetail', $newProduct->url_key) }}"><i class="fa fa-shopping-cart"></i>Buy Now</a>
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
                    @foreach ($products as $productTags)
                        <a href="{{ route('productdetail', $productTags->url_key) }}">{{ $productTags->meta_tag }}</a>
                    @endforeach
                </div>
            </div>
            <!-- Side Bar End -->
        </div>
    </div>
</div>
@endsection
