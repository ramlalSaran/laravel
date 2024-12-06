<div class="top-bar">
    <div class="container-fluid">
        <div class="row">
            <div class="col-sm-6">
                <i class="fa fa-envelope"></i>
                <a href="mailto:ramlalsaranofficial@gmail.com">ramlalsaranofficial@gmail.com</a>

            </div>
            <div class="col-sm-6">
                <i class="fa fa-phone-alt"></i>
                +91 9376136511
            </div>
        </div>
    </div>
</div>
<!-- Top bar End -->

<!-- Nav Bar Start -->
<div class="nav">
    <div class="container-fluid">
        <nav class="navbar navbar-expand-md bg-dark navbar-dark">
            <a href="#" class="navbar-brand">MENU</a>
            <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                <span class="navbar-toggler-icon"></span>
            </button>

            <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                <div class="navbar-nav mr-auto">
                    <a href="{{ route('home') }}" class="nav-item nav-link active">Home</a>
                    @foreach (HeadPages() as $page)
                        <a href="{{ route('page', $page->url_key) }}" class="nav-item nav-link">{{ $page->title }}</a>
                    @endforeach

                    {{-- category and subCategory --}}
                    @foreach (categories() as $category)
                        <div class="nav-item dropdown">
                            <a href="{{ route('CategotyPage', $category->url_key) }}" class="nav-link dropdown-toggle"
                                data-toggle="dropdown">{{ $category->name }}</a>
                            <div class="dropdown-menu">
                                @foreach (Subcategories($category->id) as $SubCategory)
                                    <a href="{{ route('CategotyPage', $SubCategory->url_key) }}"
                                        class="dropdown-item">{{ $SubCategory->name }}</a>
                                @endforeach
                            </div>
                        </div>
                    @endforeach
                    {{-- <a href="{{route('cart.index')}}" class=" text-white nav-item nav-link active">Cart</a> --}}

                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">More Pages</a>
                        <div class="dropdown-menu">
                            <a href="{{ route('contact') }}" class="dropdown-item">Contact Us</a>
                        </div>
                    </div>


                </div>
                <div class="navbar-nav ml-auto">
                    <div class="nav-item dropdown">
                        <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown">User Account</a>
                        <div class="dropdown-menu">

                            @if (Auth::check())
                                <a href="{{ route('userProfile') }}" class="dropdown-item">
                                    &nbsp;@if(auth()->user()->getFirstMediaUrl('profile_image'))
                                    <!-- Display the user's image with rounded shape -->
                                    <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') }}" alt="User Image" 
                                    style="border-radius: 50%; object-fit: cover; width: 20px; height: 20px;">&nbsp; Profile
                                
                                    @else
                                    <i class="fa fa-user"></i>&nbsp; Profile
                                    @endif
                                     </a>
                            @else
                                <a href="{{ route('login_form') }}" class="dropdown-item">Login</a>
                                <a href="{{ route('register_form') }}" class="dropdown-item">Register</a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </nav>
    </div>
</div>

<!-- Bottom Bar Start -->
<div class="bottom-bar">
    <div class="container-fluid">
        <div class="row align-items-center">
            <div class="col-md-3">
                <div class="logo">
                    <a href="{{ route('home') }}">
                        <img src="{{ asset('e-web_assets/img/logo.png') }}" alt="Logo">
                    </a>
                </div>
            </div>
            <div class="col-md-6">
                <form action="{{ route('catalog') }}" method="get">
                    <div class="search">
                        <input type="text" placeholder="Search" name="search" value="{{request()->search}}">
                        <button type="submit"><i class="fa fa-search"></i></button>
                    </div>
                </form>
            </div>
            <div class="col-md-3">

                <div class="user">
                    @if (Auth::check())
                        <a href="{{ route('wishlist') }}" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                            <span>{{ count(AllWishlistData()) }}</span>
                        </a>
                    @else
                        <a href="{{ route('login_form') }}" class="btn wishlist">
                            <i class="fa fa-heart"></i>
                            <span>0</span>
                        </a>
                    @endif
                    <a href="{{ route('cartShow') }}" class="btn cart">
                        <i class="fa fa-shopping-cart"></i>
                        <span>{{ count(allItemsInCart()) }}</span>

                    </a>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Bottom Bar End -->
