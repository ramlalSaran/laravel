@extends('e-commerce.layouts.layout')
@section('title', 'Contact')
@section('section')
    <div class="contact">
        
        <div class="container-fluid">
            @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show" id="successAlert" role="alert">
                <strong>Success!</strong> {{ session('success') }}
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @endif
        <div class="row">
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h2>Our Office</h2>
                        <h3><i class="fa fa-map-marker"></i>123 Office, Los Angeles, CA, USA</h3>
                        <h3><i class="fa fa-envelope"></i>office@example.com</h3>
                        <h3><i class="fa fa-phone"></i>+123-456-7890</h3>
                        <div class="social">
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-linkedin-in"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-info">
                        <h2>Our Store</h2>
                        <h3><i class="fa fa-map-marker"></i>123 Store, Los Angeles, CA, USA</h3>
                        <h3><i class="fa fa-envelope"></i>store@example.com</h3>
                        <h3><i class="fa fa-phone"></i>+123-456-7890</h3>
                        <div class="social">
                            <a href=""><i class="fab fa-twitter"></i></a>
                            <a href=""><i class="fab fa-facebook-f"></i></a>
                            <a href=""><i class="fab fa-linkedin-in"></i></a>
                            <a href=""><i class="fab fa-instagram"></i></a>
                            <a href=""><i class="fab fa-youtube"></i></a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4">
                    <div class="contact-form">
                        <form action="{{ route('contactPost') }}" method="post">
                            @csrf
                            {{-- <div class="row">
                                <div class="col-md-6">
                                    <input type="text" name="name"
                                        class="form-control @error('name') border border-danger @enderror"
                                        placeholder="Your Name" value="{{ old('name') }}" />
                                    @error('name')
                                        <p class="text-danger d-flex align-items-center">
                                            <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                                <div class="col-md-6">
                                    <input type="email" name="email"
                                        class="form-control @error('email') border border-danger @enderror"
                                        placeholder="Your Email" value="{{ old('email') }}" />
                                    @error('email')
                                        <p class="text-danger d-flex align-items-center">
                                            <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                                </div>
                            </div> --}}
                            <div class="form-group">
                                <input type="text" name="name"
                                        class="form-control @error('name') border border-danger @enderror"
                                        placeholder="Your Name" value="{{ old('name') }}" />
                                    @error('name')
                                        <p class="text-danger d-flex align-items-center">
                                            <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                        </p>
                                    @enderror
                            </div>
                            <div class="form-group">
                                <input type="email" name="email"
                                class="form-control @error('email') border border-danger @enderror"
                                placeholder="Your Email" value="{{ old('email') }}" />
                            @error('email')
                                <p class="text-danger d-flex align-items-center">
                                    <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                </p>
                            @enderror
                            </div>
                            <div class="form-group">
                                <input type="text" name="phone"
                                    class="form-control @error('phone') border border-danger @enderror"
                                    placeholder="Phone Number" value="{{ old('phone') }}" />
                                @error('phone')
                                    <p class="text-danger d-flex align-items-center">
                                        <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>
                            <div class="form-group">
                                <textarea class="form-control @error('message') border border-danger @enderror" name="message" rows="5"
                                    placeholder="Message">{{ old('message') }}</textarea>
                                @error('message')
                                    <p class="text-danger d-flex align-items-center">
                                        <i class="fas fa-times-circle me-2"></i>{{ $message }}
                                    </p>
                                @enderror
                            </div>

                            <div><button class="btn" type="submit">Send Message</button></div>
                        </form>
                    </div>
                </div>
                <div class="col-lg-12">
                    <div class="contact-map">
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3305.733248043701!2d-118.24532098539802!3d34.05071312525937!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x80c2c648fa1d4803%3A0xdec27bf11f9fd336!2s123%20S%20Los%20Angeles%20St%2C%20Los%20Angeles%2C%20CA%2090012%2C%20USA!5e0!3m2!1sen!2sbd!4v1585634930544!5m2!1sen!2sbd"
                            frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false"
                            tabindex="0"></iframe>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

