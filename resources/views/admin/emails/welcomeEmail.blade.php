<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Welcome Email</title>
  <style>
    /* Basic styling for the email */
    body {
      font-family: Arial, sans-serif;
      font-size: 16px;
      line-height: 1.5;
      margin: 0;
      padding: 20px;
    }

    .container {
      max-width: 600px;
      margin: 0 auto;
      padding: 20px;
      border-radius: 5px;
      background-color: #f2f2f2;
    }

    h1 {
      font-size: 24px;
      font-weight: bold;
      margin-bottom: 10px;
    }

    p {
      margin-bottom: 10px;
    }

    .button {
      display: inline-block;
      padding: 10px 20px;
      background-color: #007bff;
      color: #fff;
      text-decoration: none;
      border-radius: 5px;
    }

    .footer {
      text-align: center;
      font-size: 12px;
      color: #888;
      margin-top: 20px;
    }
  </style>
</head>
<body>
  <div class="container">
    <h1>Welcome!</h1>
    <h2>email:{{$emailsend->email}}</h2>
    <span>name:{{$emailsend->name}}</span> <span>phone:{{$emailsend->phone}}</span>
    <p>We're excited to have you get started. First, you need to confirm your account. Just press the button below.</p>
    <a href="{{route('login_form')}}" class="button">Confirm Account</a>
    <p>If you have any questions, just reply to this email—we're always happy to help out.</p>
    <p>The Contoso Team</p>
    <div class="footer">
      Dashboard | Billing | Help
      <br>
      Contoso - 1234 Main Street - Anywhere, MA - 56789
    </div>
  </div>
</body>
</html>