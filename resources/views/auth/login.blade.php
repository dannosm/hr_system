<!doctype html>
<html lang="en">
 
<head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Login Hr System</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../assets/vendor/bootstrap/css/bootstrap.min.css">
    <link href="../assets/vendor/fonts/circular-std/style.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/libs/css/style.css">
    <link rel="stylesheet" href="../assets/vendor/fonts/fontawesome/css/fontawesome-all.css">
    <style>
    html,
    body {
        height: 100%;
    }

    body {
        display: -ms-flexbox;
        display: flex;
        -ms-flex-align: center;
        align-items: center;
        padding-top: 40px;
        padding-bottom: 40px;
    }
    </style>
</head>

<body>
    <!-- ============================================================== -->
    <!-- login page  -->
    <!-- ============================================================== -->
    <div class="splash-container">
        <div class="card ">
            <div class="card-header text-center"><!-- <a href="../index.html"><img class="logo-img" src="../assets/images/logo.png" alt="logo" -->
                <h1><img  alt="HR System" width="" height="" id="set_image_1"/></h1>
            </a><!-- <span class="splash-description">Login</span> --></div>
            <div class="card-body">
                 <form method="POST" action="{{ route('login') }}">
                 @csrf
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('email') is-invalid @enderror" id="text" type="text"  name="email" value="{{ old('email') }}" required autocomplete="email" autofocus id="username" placeholder="username or email">
                    </div>
                    <div class="form-group">
                        <input class="form-control form-control-lg @error('password') is-invalid @enderror" id="password" type="password"  name="password" required autocomplete="current-password" placeholder="password">
                    </div>
                    <div class="form-group">
                        <label class="custom-control custom-checkbox">
                            <input class="custom-control-input" type="checkbox"><span class="custom-control-label">Remember Me</span>
                        </label>
                    </div>
                    <button type="submit" class="btn btn-primary btn-lg btn-block">Login</button>
                </form>
            </div>
            <div class="card-footer bg-white p-0 ">
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Login</a></div>
                <div class="card-footer-item card-footer-item-bordered">
                    <a href="#" class="footer-link">Forgot Password</a>
                </div>
            </div>
        </div>
    </div>
  
    <!-- ============================================================== -->
    <!-- end login page  -->
    <!-- ============================================================== -->
    <!-- Optional JavaScript -->
    <script src="../assets/vendor/jquery/jquery-3.3.1.min.js"></script>
    <script src="../assets/vendor/bootstrap/js/bootstrap.bundle.js"></script>
     <script src="{{URL::to('/')}}/assets/modul/page_setting/page_setting.js"></script>

     <script type="text/javascript">
         var page_setting = new page_setting();
        (function($) {
            $(document).ready(function() {
                 
                  page_setting.set_page({url:"{{url('/setting/set-page')}}",token:$("input[name='_token']").val()});

                $("#form-login").hide();
                $("#username").focus();

                $('.list-inline li > a').click(function() {
                    var activeForm = $(this).attr('href') + ' > form';
                    //console.log(activeForm);
                    $(activeForm).addClass('animated fadeIn');
                    //set timer to 1 seconds, after that, unload the animate animation
                    setTimeout(function() {
                        $(activeForm).removeClass('animated fadeIn');
                    }, 1000);
                });
            });
        })(jQuery);


        $("#forgots").on('click',function(){
            $("#emails").focus();
            $("#form-login").show();
        })
        $("#tap-login").click(function(){
            $("#username").focus();
            $("#form-login").hide();
        })

    </script>
</body>
 
</html>