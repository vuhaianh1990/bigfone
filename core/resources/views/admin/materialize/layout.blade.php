<!doctype html>
<html lang="{{ app()->getLocale() }}">
<head>
  <meta charset="UTF-8">
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
  <meta name="csrf-token" content="{{ csrf_token() }}" />
  <title>@yield('title')</title>

  <!-- Favicon-->
  <link rel="icon" href="{{ admin_asset('images/favicon.ico') }}" type="image/x-icon">

  <!-- Google Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&subset=latin,cyrillic-ext" rel="stylesheet" type="text/css">
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet" type="text/css">

  <!-- Bootstrap Core Css -->
  <link href="{{ admin_asset('plugins/bootstrap/css/bootstrap.css') }}" rel="stylesheet">

  <!-- Waves Effect Css -->
  <link href="{{ admin_asset('plugins/node-waves/waves.css') }}" rel="stylesheet" />

  <!-- Animation Css -->
  <link href="{{ admin_asset('plugins/animate-css/animate.css') }}" rel="stylesheet" />

  <!-- Sweetalert Css -->
  <link href="{{ admin_asset('plugins/sweetalert/sweetalert.css') }}" rel="stylesheet" />

  <!-- Owl Carousel -->
  <link rel="stylesheet" href="{{ admin_asset('css/owlcarousel.min.css') }}" />

  <!-- Custom Css -->
  <link href="{{ admin_asset('css/style.min.css') }}" rel="stylesheet">

  <!-- AdminBSB Themes. You can choose a theme from css/themes instead of get all themes -->
  <link href="{{ admin_asset('css/all-themes.min.css') }}" rel="stylesheet" />

  <!-- Fonts -->
  <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
  <link rel="stylesheet" href="{{ admin_asset('css/custom.css') }}">
  @stack('css')
</head>
<body class="theme-red">

  {{-- HEADER --}}
  @include(admin_theme().'partials.header')

  <section>
    {{-- NAVIGATION --}}
    @include(admin_theme().'partials.nav')
    {{-- SKIN --}}
    @include(admin_theme().'partials.skin')
  </section>

  <section class="content">
    <div class="container-fluid">
    @yield('content')
    </div>
  </section>

  <!-- Jquery Core Js -->
  <script src="{{ admin_asset('plugins/jquery/jquery.min.js') }}"></script>

  <!-- Bootstrap Core Js -->
  <script src="{{ admin_asset('plugins/bootstrap/js/bootstrap.js') }}"></script>

  <!-- Select Plugin Js -->
  <script src="{{ admin_asset('plugins/bootstrap-select/js/bootstrap-select.js') }}"></script>

  <!-- Slimscroll Plugin Js -->
  <script src="{{ admin_asset('plugins/jquery-slimscroll/jquery.slimscroll.js') }}"></script>

  <!-- Bootstrap Notify Plugin Js -->
  <script src="{{ admin_asset('plugins/bootstrap-notify/bootstrap-notify.js') }}"></script>
  <!-- SweetAlert Plugin Js -->
  <script src="{{ admin_asset('plugins/sweetalert/sweetalert.min.js') }}"></script>

  <!-- Waves Effect Plugin Js -->
  <script src="{{ admin_asset('plugins/node-waves/waves.js') }}"></script>

  <!-- Custom Js -->
  <script src="{{ admin_asset('js/admin.js') }}"></script>

  <!-- Demo Js -->
  <script src="{{ admin_asset('js/demo.js') }}"></script>

  <script src="https://sdk.accountkit.com/en_US/sdk.js"></script>

  <script>
    // Add class Active to navigation menu
    var route = location.href;
    var pattern = /.+\/$/i;
    if (route.match(pattern) !== null) {
      route = route.substr(0, route.lastIndexOf('/'));
    }
    $('.menu .list li a').each(function(){
      var $this = $(this);
      var url   = $this.attr('href');

      // if the current path is like this link, make it active
      if(url === route){
        $this.parent().addClass('active');
        li = $this.parent().parent().parent();
        if (li.prop('tagName') === 'LI') {
          li.addClass('active');
        }
      }
    });

    // Remove hash login fb
    if (window.location.hash && window.location.hash == '#_=_') {
        if (window.history && history.pushState) {
            window.history.pushState("", document.title, window.location.pathname);
        } else {
            // Prevent scrolling by storing the page's current scroll offset
            var scroll = {
                top: document.body.scrollTop,
                left: document.body.scrollLeft
            };
            window.location.hash = '';
            // Restore the scroll offset, should be flicker free
            document.body.scrollTop = scroll.top;
            document.body.scrollLeft = scroll.left;
        }
        location.reload();
    }


    function callPhone() {
        AccountKit.login(
            'PHONE',
            {countryCode: '+84', phoneNumber: ''},
            loginCallback
        );
    }

    // initialize Account Kit with CSRF protection
    AccountKit_OnInteractive = function(){
        AccountKit.init(
            {
            appId:"1931115790243808",
            state:"bf9d959366eff360d6f31f0c7927033f",
            version:"v1.1",
            debug:true
              // fbAppEventsEnabled:true,
              // redirect:"https://facefone.azvidi.com/"
            }
        );
    };

    // login callback
    function loginCallback(response) {
      if (response.status === "PARTIALLY_AUTHENTICATED") {
        var code = response.code;
        var csrf = response.state;

        $.ajax({
            type: "GET",
            url: '/verifyPhone',
            data: {
                code:code
            },
            dataType: "json",
            success: function (res) {
                if (res.status === 200) {
                  swal("Thành công!", "Chúc mừng bạn đã cập nhật thành công!.", "success");
                  setTimeout(() => {
                    location.reload();
                  }, 4000);
                }
            }
        });

        // Send code to server to exchange for access token
      }
      else if (response.status === "NOT_AUTHENTICATED" || response.status === "BAD_PARAMS") {
        swal("Lưu ý", "Hãy nhập số điện thoại giúp hệ thống quản lý tốt hơn!", "warning");
      }
    }

    // phone form submission handler
    function smsLogin() {
      var countryCode = document.getElementById("country_code").value;
      var phoneNumber = document.getElementById("phone_number").value;
      AccountKit.login(
          'PHONE',
          {countryCode: countryCode, phoneNumber: phoneNumber}, // will use default values if not specified
          loginCallback
      );
    }

  </script>

  @if (Auth::user()->phone == '')
  <script type="text/javascript">
    setTimeout(function () {
      swal({
          title: "Bạn chưa cập nhật số điện thoại?",
          text: "Hãy nhập số điện thoại giúp hệ thống quản lý tốt hơn!",
          type: "warning",
          showCancelButton: true,
          confirmButtonColor: "#DD6B55",
          confirmButtonText: "Tôi đồng ý!",
          cancelButtonText: "Để sau!",
          closeOnConfirm: false,
          closeOnCancel: false
      }, function (isConfirm) {
          if (isConfirm) {
            callPhone();
          } else {
              swal("Lưu ý", "Hãy nhập số điện thoại giúp hệ thống quản lý tốt hơn!", "warning");
          }
      });
    }, 6000);

  </script>
  @endif

  @stack('js')
</body>
</html>