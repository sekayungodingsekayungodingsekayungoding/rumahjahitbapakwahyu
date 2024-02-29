<html lang="en">
  <head>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, viewport-fit=cover"/>
    <meta http-equiv="X-UA-Compatible" content="ie=edge"/>
    <title>Panel Login</title>
    <!-- CSS files -->
    <link href="{{ asset('dist/css/tabler.min.css?1674944402') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-flags.min.css?1674944402') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-payments.min.css?1674944402') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/tabler-vendors.min.css?1674944402') }}" rel="stylesheet"/>
    <link href="{{ asset('dist/css/demo.min.css?1674944402') }}" rel="stylesheet"/>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/css/bootstrap.min.css" integrity="sha384-B0vP5xmATw1+K9KRQjQERJvTumQW0nPEzvF6L/Z6nronJ3oUOFUFpCjEUQouq2+l" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.4.1/font/bootstrap-icons.css">
    <style>
      @import url('https://rsms.me/inter/inter.css');
      :root {
      	--tblr-font-sans-serif: 'Inter Var', -apple-system, BlinkMacSystemFont, San Francisco, Segoe UI, Roboto, Helvetica Neue, sans-serif;
      }
      body {
      	font-feature-settings: "cv03", "cv04", "cv11";
      }
    </style>
  </head>
  <body  class=" d-flex flex-column">
    <script src="{{ asset('dist/js/demo-theme.min.js?1674944402') }}"></script>
    <div class="page page-center" style="backgroundcolor: #fff;">
      <div class="container container-normal py-4">
        <div class="row align-items-center g-4">
          <div class="col-lg">
            <div class="container-tight">
              <div class="text-center mb-4">
                <a href="." class="navbar-brand navbar-brand-autodark"><img src="{{ asset('assets/img/icon/i.png') }}" height="200" alt=""></a>
              </div>
              <div class="card card-md">
                <div class="card-body">
                  <h2 class="h2 text-center mb-4">Login to your account</h2>
                  @php
                      $messagewarning = Session::get('warning');
                  @endphp
                  @if (Session::get('warning'))
                      <div class="alert alert-outline-danger">
                          {{ $messagewarning }}
                      </div>
                  @endif
                  <form action="/loginadmin" method="post" autocomplete="off" novalidate>
                    @csrf
                    <div class="mb-3">
                      <label class="form-label">Email address</label>
                      <input type="email" class="form-control" name="email" id="email" placeholder="your@email.com" autocomplete="off">
                    </div>
                    <div class="mb-2">
                      <label class="form-label">
                        Password

                      </label>
                      <div class="input-group input-group-flat">
                        <div class="input-group" id="show_hide_password">
                          <input type="password" name='password' class="form-control" name="password" required autocomplete="current-password">
                          <div class="input-group-append">
                              <a href="" class="btn btn-outline-secondary"><i class="bi bi-eye-slash" aria-hidden="true"></i></a>
                          </div>
                      </div>
                      </div>
                    </div>

                    <div class="form-footer">
                      <button type="submit" class="btn btn-success w-100">Sign in</button>
                    </div>
                  </form>
                </div>
              </div>
            </div>
          </div>
          <div class="col-lg d-none d-lg-block">
            <img src="{{ asset('dist/static/illustrations/undraw_secure_login_pdn4.svg') }}" height="300" class="d-block mx-auto" alt="">
          </div>
        </div>
      </div>
    </div>
    <!-- Libs JS -->
    <!-- Tabler Core -->
    <script src="{{ asset('dist/js/tabler.min.js?1674944402') }}" defer></script>
    <script src="{{ asset('dist/js/demo.min.js?1674944402') }}" defer></script>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-Piv4xVNRyMGpqkS2by6br4gNJ7DXjqk09RmUpJ8jgGtD7zP9yug3goQfGII0yAns" crossorigin="anonymous"></script>
    <script>
      $(document).ready(function(){
        $("#show_hide_password a").on('click', function(event) {
            event.preventDefault();
            if($('#show_hide_password input').attr("type") == "text"){
                $('#show_hide_password input').attr('type', 'password');
                $('#show_hide_password i').addClass( "bi bi-eye-slash" );
                $('#show_hide_password i').removeClass( "bi bi-eye" );
            }else if($('#show_hide_password input').attr("type") == "password"){
                $('#show_hide_password input').attr('type', 'text');
                $('#show_hide_password i').removeClass( "bi bi-eye-slash" );
                $('#show_hide_password i').addClass( "bi bi-eye" );
            }
        });
      });
    </script>
  </body>
</html>
