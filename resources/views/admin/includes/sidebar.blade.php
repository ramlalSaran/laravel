<ul class="navbar-nav sidebar sidebar-light accordion" id="accordionSidebar">
    <a class="sidebar-brand d-flex align-items-center justify-content-center" href="{{ route('dashboard.index') }}">
        <div class="sidebar-brand-icon">
            <img src="{{ auth()->user()->getFirstMediaUrl('profile_image') }}" class="rounded-circle" alt="Profile Image">
        </div>

        <div class="sidebar-brand-text mx-3">{{ auth()->user()->name }}</div>
    </a>
    <hr class="sidebar-divider my-0">
    @can('dashboard_index')
        <li class="nav-item active">
            <a class="nav-link" href="{{ route('dashboard.index') }}">
                <i class="fas fa-fw fa-tachometer-alt"></i>
                <span>Dashboard</span></a>
        </li>
    @endcan


    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        Admin Mangemenat
    </div>
    @can('user_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#collapseBootstrap"
                aria-expanded="true" aria-controls="collapseBootstrap">
                <i class="fa fa-users "></i>
                <span><b>Users</b></span>
            </a>
            <div id="collapseBootstrap" class="collapse" aria-labelledby="headingBootstrap" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">User Elemeants</h6>
                    @can('user_index')
                        <a class="collapse-item" href="{{ route('user.index') }}">Users Tabel</a>
                    @endcan
                    @can('user_create')
                        <a class="collapse-item" href="{{ route('user.create') }}">User Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    @can('permission_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#permission"
                aria-expanded="true" aria-controls="permission">
                <i class="fa fa-lock"></i>
                <span><b>Permissions</b></span>
            </a>
            <div id="permission" class="collapse" aria-labelledby="permission" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header">Permission Elemeants</h6>
                    @can('permission_index')
                        <a class="collapse-item" href="{{ route('permission.index') }}">Permissions Tabel</a>
                    @endcan

                    @can('permission_create')
                        <a class="collapse-item" href="{{ route('permission.create') }}">Permissions Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    @can('role_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#role" aria-expanded="true"
                aria-controls="role">
                <i class="fa fa-user-shield"></i>
                <span><b>Roles</b></span>
            </a>
            <div id="role" class="collapse" aria-labelledby="role" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Role Elemeants</h6>
                    @can('role_index')
                        <a class="collapse-item" href="{{ route('role.index') }}">Roles Tabel</a>
                    @endcan
                    @can('role_create')
                        <a class="collapse-item" href="{{ route('role.create') }}">Roles Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    @can('slider_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#slider" aria-expanded="true"
                aria-controls="slider">
                <i class="fas fa-sliders-h"></i>

                <span><b>Sliders</b></span>
            </a>
            <div id="slider" class="collapse" aria-labelledby="slider" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> slider Elemeants</h6>
                    @can('slider_index')
                        <a class="collapse-item" href="{{ route('slider.index') }}">Sliders Tabel</a>
                    @endcan
                    @can('slider_create')
                        <a class="collapse-item" href="{{ route('slider.create') }}">Slider Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan

    @can('page_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#page" aria-expanded="true"
                aria-controls="page">
                <i class="fas fa-copy"></i>
                <span><b>Pages</b></span>
            </a>
            <div id="page" class="collapse" aria-labelledby="page" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Page Elemeants</h6>
                    @can('page_index')
                        <a class="collapse-item" href="{{ route('page.index') }}">Pages Tabel</a>
                    @endcan
                    @can('page_create')
                        <a class="collapse-item" href="{{ route('page.create') }}">Page Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan
    @can('block_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#block"
                aria-expanded="true" aria-controls="block">
                <i class="fas fa-th"></i>
                <span><b>Blocks</b></span>
            </a>
            <div id="block" class="collapse" aria-labelledby="block" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Block Elemeants</h6>
                    @can('block_index')
                        <a class="collapse-item" href="{{ route('block.index') }}">Blocks Tabel</a>
                    @endcan
                    @can('block_create')
                        <a class="collapse-item" href="{{ route('block.create') }}">Block Create</a>
                    @endcan
                </div>
            </div>
        </li>
    @endcan


    @can('enquiry_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#enquiry"
                aria-expanded="true" aria-controls="enquiry">
                <i class="fas fa-question-circle"></i>

                <span><b>enquiries</b></span>
            </a>
            <div id="enquiry" class="collapse" aria-labelledby="role" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    <h6 class="collapse-header"> Enquiry Elemeants</h6>

                    <a class="collapse-item" href="{{ route('enquiries.index') }}">Enquiry Tabel</a>

                </div>
            </div>
        </li>
    @endcan












    <hr class="sidebar-divider">
    <div class="sidebar-heading">
        E-Commerce Section
    </div>
    @can('product_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#Products"
                aria-expanded="true" aria-controls="Products">
                <i class="fas fa-cube"></i>
                <strong><span>Products</span></strong>
            </a>
            <div id="Products" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('product_create')
                        <a class="collapse-item" href="{{ route('product.create') }}">Product Create</a>
                    @endcan
                    @can('product_index')
                        <a class="collapse-item" href="{{ route('product.index') }}">Product Table</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcan


    @can('attribute_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#attribute"
                aria-expanded="true" aria-controls="attribute">
                <i class="fas fa-puzzle-piece"></i>
                <strong><span>Attribute</span></strong>
            </a>
            <div id="attribute" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('attribute_create')
                        <a class="collapse-item" href="{{ route('attribute.create') }}">Attribute Create</a>
                    @endcan
                    @can('attribute_index')
                        <a class="collapse-item" href="{{ route('attribute.index') }}">Attribute Table</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcan
    @can('attributevalue_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#attributevalue"
                aria-expanded="true" aria-controls="attributevalue">
                <i class="fas fa-code"></i>
                <strong><span>Attribute Value</span></strong>
            </a>
            <div id="attributevalue" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('attributevalue_create')
                        <a class="collapse-item" href="{{ route('attributevalue.create') }}">Attribute Value Create</a>
                    @endcan
                    @can('attributevalue_index')
                        <a class="collapse-item" href="{{ route('attributevalue.index') }}">Attribute Values Table</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcan
    @can('category_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#category"
                aria-expanded="true" aria-controls="category">
                <i class="fa fa-list"></i>
                <strong><span>Category</span></strong>
            </a>
            <div id="category" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('category_create')
                        <a class="collapse-item" href="{{ route('category.create') }}">Category Create</a>
                    @endcan
                    @can('category_index')
                        <a class="collapse-item" href="{{ route('category.index') }}">Categories Table</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcan
    @can('coupon_index')
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#coupon"
                aria-expanded="true" aria-controls="coupon">
                <i class="fa fa-ticket"></i>
                <strong><span>Coupon</span></strong>
            </a>
            <div id="coupon" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    @can('coupon_create')
                        <a class="collapse-item" href="{{ route('coupon.create') }}">Coupon Create</a>
                    @endcan
                    @can('coupon_index')
                        <a class="collapse-item" href="{{ route('coupon.index') }}">Coupons Table</a>
                    @endcan

                </div>
            </div>
        </li>
    @endcan
    {{-- @can('coupon_index') --}}
        <li class="nav-item">
            <a class="nav-link collapsed" href="#" data-toggle="collapse" data-target="#brand"
                aria-expanded="true" aria-controls="brand">
                <i class="fa fa-ticket"></i>
                <strong><span>Brands</span></strong>
            </a>
            <div id="brand" class="collapse" aria-labelledby="headingPage" data-parent="#accordionSidebar">
                <div class="bg-white py-2 collapse-inner rounded">
                    {{-- @can('brand_create') --}}
                        <a class="collapse-item" href="{{ route('brand.create') }}">Brand Create</a>
                    {{-- @endcan --}}
                    {{-- @can('brand_index') --}}
                        <a class="collapse-item" href="{{ route('brand.index') }}">Brands Table</a>
                    {{-- @endcan --}}

                </div>
            </div>
        </li>
    {{-- @endcan --}}
    <hr>
    @can('profile')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('user.profile') }}" aria-expanded="false" aria-controls="profile">
            <i class="fas fa-user"></i>
            <span><strong>Profile</strong></span>
        </a>
    </li>
    @endcan
    @can('manage_order')
    <li class="nav-item">
        <a class="nav-link" href="{{ route('order') }}" aria-expanded="false" aria-controls="Order">
            <i class="fas fa-store"></i>
            <span><strong>Manage Order</strong></span>
        </a>
    </li>
    @endcan
</ul>
