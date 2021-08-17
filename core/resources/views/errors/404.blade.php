<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <title>404</title>
  <link rel="icon" href="{{ asset('images/favicon.ico') }}" type="image/x-icon">
  <link href="{{ asset('css/app.css') }}" rel="stylesheet">
  <style>
    body {
      font-family: 'Roboto', Arial, Tahoma, sans-serif;
    }

    .four-zero-four {
      margin-bottom: 126px;
      width: 100%;
      text-align: center;
      margin: 5% auto;
      background-color: #e9e9e9;
      transition: all .5s;
    }

    .error-code {
      font-size: 160px;
    }

    .error-message {
      font-size: 26px;
      color: #333;
      font-weight: bold;
      margin-top: -40px;
    }

    .button-place {
      margin-top: 32px;
    }

    .btn:not(.btn-link):not(.btn-circle) {
      box-shadow: 0 2px 5px rgba(0, 0, 0, .16), 0 2px 10px rgba(0, 0, 0, .12);
      -webkit-border-radius: 2px;
      -moz-border-radius: 2px;
      -ms-border-radius: 2px;
      border-radius: 2px;
      border: none;
      font-size: 13px;
      outline: none;
    }

    .btn-default, .btn-default:hover, .btn-default:active, .btn-default:focus {
      background-color: #fff !important;
      color: #0D0A0A;
    }

    button, input, select, a {
      outline: none !important;
    }
  </style>
</head>

<body class="four-zero-four">
<div class="four-zero-four-container">
  <div class="error-code">404</div>
  <div class="error-message">PAGE NÀY KHÔNG TÌM THẤY</div>
  <div class="button-place">
    <a href="{{ admin_route('home') }}" class="btn btn-default btn-lg waves-effect">TRỞ VỀ TRANG CHỦ</a>
  </div>
</div>
</body>
</html>