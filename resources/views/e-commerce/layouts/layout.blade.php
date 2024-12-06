@include('e-commerce.includes.head')
        <!-- Top bar Start -->
        {{-- nav --}}
        @include('e-commerce.includes.navbar')
        <!-- Nav Bar End -->      
        
             
        
        <!-- Main Slider Start -->
       @yield('section')
        <!-- Review End -->        
        
        <!-- Footer Start -->
    @include('e-commerce.includes.footer')
    @yield('script')
    @include('e-commerce.includes.script')
        <!-- Footer Bottom End -->       
        
        <!-- Back to Top -->
      
