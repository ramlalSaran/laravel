<div class="footer">
    <div class="container-fluid">
        <div class="row">
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Get in Touch</h2>
                    <div class="contact-info">
                        <p><i class="fa fa-map-marker"></i>{{env('ADDRESS_')}}</p>
                        <p><i class="fa fa-envelope"></i>{{env('EMAIL_ADD')}}</p>
                        <p><i class="fa fa-phone"></i>{{env('MOBAIL_NO')}}</p>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Follow Us</h2>
                    <div class="contact-info">
                        <div class="social">
                           
                            <a href="{{env('FACEBOOK_URL')}}"><i class="fab fa-facebook-f"></i></a>
                            <a href="{{env('LINKEDIN_URL')}}"><i class="fab fa-linkedin-in"></i></a>
                            <a href="{{env('INSTAGRAM_URL')}}"><i class="fab fa-instagram"></i></a>
                     
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Company Info</h2>
                    <ul>
                        @foreach (FooterPages()['firstPart'] as $page)
                            <li><a href="{{ route('page', $page->url_key) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>
            </div>
        
            <!-- Second Part: Purchase Info (Next pages) -->
            <div class="col-lg-3 col-md-6">
                <div class="footer-widget">
                    <h2>Purchase Info</h2>
                    <ul>
                        @foreach (FooterPages()['secondPart'] as $page)
                            <li><a href="{{ route('page', $page->url_key) }}">{{ $page->title }}</a></li>
                        @endforeach
                    </ul>
                </div>

            </div>

        {{-- <div class="row payment align-items-center">
            <div class="col-md-6">
                <div class="payment-method">
                    <h2>We Accept:</h2>
                    <img src="{{ asset('e-web_assets/img/payment-method.png') }}" alt="Payment Method" />
                </div>
            </div>
            <div class="col-md-6">
                <div class="payment-security">
                    <h2>Secured By:</h2>
                    <img src="{{ asset('e-web_assets/img/godaddy.svg') }}" alt="Payment Security" />
                    <img src="{{ asset('e-web_assets/img/norton.svg') }}" alt="Payment Security" />
                    <img src="{{ asset('e-web_assets/img/ssl.svg') }}" alt="Payment Security" />
                </div>
            </div>
        </div> --}}
    </div>
</div>
<!-- Footer End -->
<!-- Footer Bottom Start -->
<div class="footer-bottom">
    <div class="container">
        <div class="row">
            <div class="col-md-6 copyright">
                <p>Copyright &copy; <a href="https://github.com/ramlalSaran ">laravel E-Store </a>. All Rights Reserved
                </p>
            </div>

            {{-- <div class="col-md-6 template-by">
                <!--/*** This template is free as long as you keep the footer author’s credit link/attribution link/backlink. If you'd like to use the template without the footer author’s credit link/attribution link/backlink, you can purchase the Credit Removal License from "https://htmlcodex.com/credit-removal". Thank you for your support. ***/-->					
                <p>Designed By <a href="https://htmlcodex.com">HTML Codex</a></p>
            </div> --}}
        </div>
    </div>
</div>
