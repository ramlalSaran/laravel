<!DOCTYPE html>
<html lang="en">

<head>

  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{asset('admin_assets/img/logo/logo.png')}}" rel="icon">
  <title>Admin-Login</title>
  <link href="{{asset('admin_assets/vendor/fontawesome-free/css/all.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin_assets/vendor/bootstrap/css/bootstrap.min.css')}}" rel="stylesheet" type="text/css">
  <link href="{{asset('admin_assets/css/ruang-admin.min.css')}}" rel="stylesheet">

</head>

<body class="bg-gradient-login">
  <!-- Login Content -->
  <div class="container-login">
    <div class="row justify-content-center">
      <div class="col-xl-6 col-lg-12 col-md-9">
        <div class="card shadow-sm my-5">
          <div class="card-body p-0">
            @if (session('error'))
            <div class="alert alert-danger alert-dismissible" role="alert">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                {{ session('error') }}
            </div>
            @endif
            <div class="row">
              <div class="col-lg-12">
                <div class="login-form">
                  <div class="text-center">
                    <h1 class="h4 text-gray-900 mb-4">WelCome to admin login  👏</h1>
                  </div>
                  <div class="float-left">
                    <h1 class="h4 text-gray-900 mb-4">Admin required</h1>
                  </div>

                  <form class="user" action="{{route('loginPost')}}" method="POST">
                    @csrf
                    {{-- user email --}}
                    <div class="form-group">
                      <input type="email" class="form-control @error('email') border-danger @enderror" id="email" name="email" aria-describedby="emailHelp" placeholder="A Valid Email Address" value="{{old('email')}}">
                        @error('email')
                        <p class="text-danger">{{$message}}</p>
                    @enderror
                    </div>
                    {{-- password --}}
                    <div class="form-group">
                      <input type="password" class="form-control @error('password') border-danger @enderror" id="password" name="password" placeholder="Enter Correct Password">
                      @error('password')
                          <p class="text-danger">{{$message}}</p>
                      @enderror
                    </div>
                    
                    <div class="form-group">
                      <button type="submit" class="btn btn-primary btn-block">Login</button>
                    </div>
                    <hr>
                    {{-- <a href="index.html" class="btn btn-google btn-block">
                      <i class="fab fa-google fa-fw"></i> Login with Google
                    </a>
                    <a href="index.html" class="btn btn-facebook btn-block">
                      <i class="fab fa-facebook-f fa-fw"></i> Login with Facebook
                    </a> --}}
                  </form>
                  <hr>
                  {{-- <div class="text-center">
                    <a class="font-weight-bold small" href="register.html">Create an Account!</a>
                  </div> --}}
                  <div class="text-center">
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
  <!-- Login Content -->
  <script src="{{asset('admin_assets/vendor/jquery/jquery.min.js')}}"></script>
  <script src="{{asset('admin_assets/vendor/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
  <script src="{{asset('admin_assets/vendor/jquery-easing/jquery.easing.min.js')}}"></script>
  <script src="{{asset('admin_assets/js/ruang-admin.min.js')}}"></script>
</body>

</html>