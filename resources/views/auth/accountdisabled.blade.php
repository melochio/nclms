<!DOCTYPE html>
<html lang="en">
<head>
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>My NC e-learning for NC</title>
    <meta content='width=device-width, initial-scale=1.0, shrink-to-fit=no' name='viewport' />
    <link rel="icon" href="/assets/img/logo.png" type="image/x-icon"/>

    <!-- Fonts and icons -->
    <script src="/assets/js/plugin/webfont/webfont.min.js"></script>
    <script>
        WebFont.load({
            google: {"families":["Lato:300,400,700,900"]},
            custom: {"families":["Flaticon", "Font Awesome 5 Solid", "Font Awesome 5 Regular", "Font Awesome 5 Brands", "simple-line-icons"], urls: ['/assets/css/fonts.min.css']},
            active: function() {
                sessionStorage.fonts = true;
            }
        });
    </script>

    <!-- CSS Files -->
    <link rel="stylesheet" href="/assets/css/bootstrap.min.css">
    <link rel="stylesheet" href="/assets/css/atlantis.min.css">
    <link rel="stylesheet" href="/assets/css/jrey.css">

    <!-- CSS Just for demo purpose, don't include it in your project -->
</head>
<style>

.c-theme-text{
    color:#030E34 !important;
}
.field-icon {
  float: right;
  margin-left: -25px;
  margin-top: 14px;
  position: relative;
  z-index: 2;
}
body{
    background-image: url("/assets/img/bg.jpg");
    background-position: center; /* Center the image */
    background-repeat: no-repeat; /* Do not repeat the image */
    background-size: cover; /* Resize the background image to cover the entire container */
    box-shadow: inset 0 0 0 2000px #ffc107ed;
}
</style>
<body class="store_bg">
    <div class="">
        <div class="">
            <div class="col-md-4 ml-auto mr-auto pt-5">
                <div class="row">
                    <div class="d-flex col-md-12 text-right" align="right">
                        <img src="/assets/img/logo.gif" style="width:35%;" class="w-full my-3 center" alt="">
                        <img src="/assets/img/logo1.gif" style="width:35%;" class="w-full my-3 center" alt="">
                    </div>
                </div>
                @if(\Session::has('message'))
                {{ \Session::get('message') }}
                @endif
                <div class="card">
                    <div class="card-header text-center" style="background-color:#007E35">
                        <div class="card-title text-white" style="font-size:17px;">My NC e-learning for NC</div>
                     </div>
                    <div class="card-body pb-0">
                        <h2 style="text-align: center">Your account has been disabled</h2>
                        <h4 style="text-align: center">Please contact the school Admin to get your account back.</h4>
                        <div class="col-md-12">&nbsp;</div>
                            <div align="center">
                                <a href="/logout" class="btn btn-success btn-round mb-4"><i class="fas fa-sign-out-alt"></i>  Logout</a>
                            </div>
                            <!-- <div class="card-action mb-3"></div> -->
                    </div>
                </div>
            </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->
    <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
</body>
</html>

<script>
    $(".toggle-password").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
</script>