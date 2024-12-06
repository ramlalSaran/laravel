@include('admin.includes.head')

<body id="page-top">
  <div id="wrapper">
    <!-- Sidebar -->
    @include('admin.includes.sidebar')
    <!-- Sidebar -->
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- TopBar -->
        @include('admin.includes.topbar')
        <!-- Topbar -->

        <!-- Container Fluid-->
        @yield('content')
        <!---Container Fluid-->
      </div>
      <!-- Footer -->
      @include('admin.includes.footer')
      <!-- Footer -->
    </div>
    </div>
    
    <!-- Scroll to top -->
@include('admin.includes.footer-js')
@yield('scripts')