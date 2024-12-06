<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <meta name="description" content="">
  <meta name="author" content="">
  <link href="{{ asset('admin_assets/img/logo/logo.png') }}" rel="icon">
  <title>Page Not Found Error 404</title>
  <link href="{{ asset('admin_assets/vendor/fontawesome-free/css/all.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('admin_assets/vendor/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet" type="text/css">
  <link href="{{ asset('admin_assets/css/ruang-admin.min.css') }}" rel="stylesheet">

  <style>
    body {
      height: 100vh; /* Full viewport height */
      display: flex; /* Flexbox for centering */
      align-items: center; /* Center vertically */
      justify-content: center; /* Center horizontally */
      background: rgba(0, 0, 0, 0.961);/* Add your background image */
      background-size: cover; /* Cover the entire body */
      background-position: center; /* Center the background image */
      color: white; /* Text color */
      text-align: center; /* Center text alignment */
      margin: 0; /* Remove default margin */
    }
    
    #content-wrapper, #content {
      background: rgba(0, 0, 0, 0.961); /* Remove background */
      border: none; /* Remove any borders */
    }
  </style>
</head>

<body id="page-top">
  <div id="wrapper">
    <div id="content-wrapper" class="d-flex flex-column">
      <div id="content">
        <!-- Container Fluid-->
        <div  id="container-wrapper">
          <div class="text-center">
            <h3 class="font-weight-bold">Oopss!</h3>
            <p class="lead mx-auto">404 Page Not Found</p>
            <a href="{{ route('home') }}" class="text-white">&larr; Back</a> <!-- Change link color to white -->
          </div>
        </div>
      </div>
    </div>
  </div>
</body>

</html>
