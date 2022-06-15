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

                <div class="card">
                    <div class="card-header text-center" style="background-color:#007E35">
                        <div class="card-title text-white" style="font-size:17px;">My NC e-learning for NC</div>
                     </div>
                    <div class="card-body pb-0">

                        <form method="POST" action="/login" id="frmlogin">
                            @csrf
                            <div class="form-group">
                                <!-- <label for="email2">Enter your username</label> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-user"></i></span>
                                    </div>
                                    <input type="text" name="username" id="uname" class="form-control" placeholder="Username" 
                                    aria-label="Username" aria-describedby="basic-addon1" required>
                                </div>
                            </div>

                            <div class="form-group mb-3" style="margin-right: 1.5%;">
                                <!-- <label for="email2">Enter your password</label> -->
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="password" id="password-field" class="form-control" placeholder="Password" required>
                                    <span style="z-index: 3;" toggle="#password-field" class="fa fa-fw fa-eye field-icon toggle-password"></span>
                                </div>
                            </div>

                            <div align="center">
                                <button type="button" id="btn-login" class="btn btn-success btn-round mb-4"><i class="fa fa-check"></i>  LOGIN</button>
                            </div>
                            <!-- <div class="card-action mb-3"></div> -->
                        </form>
                    
                    </div>
                </div>

                <div class=" text-center">
                    Forgot Password? Click <a href="#" data-toggle="modal" data-target="#forgotpasswordModal">Here</a>!
                </div>
            </div>
        <!-- End Custom template -->
    </div>
    <!--   Core JS Files   -->

    <form action="/forgotpassword" method="POST">
        @csrf
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="forgotpasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">                                  
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold">
                                Reset Password
                            </span> 
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">          
                        <div class="row p-3">
                            <div class="col-md-12 mb-2" id="error_msg">
                                <span class="text-danger">Please fill-up all the required (*) fields</span>
                            </div>    
                            <div class="col-md-6">
                                <div class="form-group form-group-default">
                                    <label><span class="text-danger">*</span> Student ID # </label>
                                    <input  type="text" name="studentid" id="studentid" class="form-control" placeholder="" required>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer no-bd" style="padding-top: 0px">
                        <button type="submit" class="btn btn-success">Submit</button>
                        <button style="float:left" type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </form>

    <form action="/changepassword" method="POST" id="frmchangepassword">
        @csrf
        <div class="modal fade" data-keyboard="false" data-backdrop="static" id="changepasswordModal" tabindex="-1" role="dialog" aria-hidden="true">
            <div class="modal-dialog" role="document">                                  
                <div class="modal-content">
                    <div class="modal-header bg-success">
                        <h5 class="modal-title">
                            <span class="fw-mediumbold">
                                Change Password
                            </span> 
                        </h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">          
                        <div class="row p-3">
                            <div class="col-md-12 mb-2" id="error_msg">
                                <span class="text-danger">Please fill-up all the required (*) fields</span>
                            </div>    
                            <div class="col-md-12 mb-2">
                                <input type="hidden" name="id" id="id_acnt">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="current_password" id="current_password" class="form-control" placeholder="Current Password" required>
                                    <span style="z-index: 3;" toggle="#current_password" class="fa fa-fw fa-eye field-icon toggle-password1"></span>
                                </div>
                            </div>  
                            <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="newpassword" id="newpassword" class="form-control" placeholder="New Password" required>
                                    <span style="z-index: 3;" toggle="#newpassword" class="fa fa-fw fa-eye field-icon toggle-password2"></span>
                                </div>
                            </div>  
                            <div class="col-md-12 mb-2">
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <span class="input-group-text" id="basic-addon1"><i class="fa fa-key"></i></span>
                                    </div>
                                    <input type="password" name="confirmpassword" id="confirmpassword" class="form-control" placeholder="Confirm Password" required>
                                    <span style="z-index: 3;" toggle="#confirmpassword" class="fa fa-fw fa-eye field-icon toggle-password3"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer no-bd" style="padding-top: 0px">
                        <button type="button" id="btn-changepass" class="btn btn-success">Submit</button>
                        <button style="float:left" type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </form>
    <script src="/assets/js/core/jquery.3.2.1.min.js"></script>
    <script src="/assets/js/core/popper.min.js"></script>
    <script src="/assets/js/core/bootstrap.min.js"></script>
</body>
<button id="btnhdn" data-toggle="modal" data-target="#changepasswordModal"></button>
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
    $(".toggle-password1").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    $(".toggle-password2").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    $(".toggle-password3").click(function() {
        $(this).toggleClass("fa-eye fa-eye-slash");
        var input = $($(this).attr("toggle"));
        if (input.attr("type") == "password") {
            input.attr("type", "text");
        } else {
            input.attr("type", "password");
        }
    });
    $('#frmchangepassword').submit(function(e){
        e.preventDefault();
    })
    $('#btn-login').click(function(e){
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '/fetch/account_status',
            data: {
                "_token": "{{ csrf_token() }}",
                "username": $('#uname').val(),
                "password": $('#password-field').val(),
            },
            async: false,
            success: function(data){
                if(data.status == 1){
                    $('#id_acnt').val(data.id)
                    $('#btnhdn').click();
                }
                else if(data.status == 2){
                    $('#frmlogin').submit();
                }
                else if(data.status == 0){
                    swal('Account does not exist!');
                }
            },
            error: function(){
                swal('Could not edit data');
            }
        });
    })
    $('#btn-changepass').click(function(e){
        if($('#confirmpassword').val() != $('#newpassword').val()){
            swal('New password and confirm password does not match');
        }
        else{
            $.ajax({
                type: 'ajax',
                method: 'post',
                url: '/check/currentpassword',
                data: {
                    "_token": "{{ csrf_token() }}",
                    "current": $('#current_password').val(),
                },
                async: false,
                success: function(data){
                    if(data == false){
                        swal('Invalid current password');
                    }
                    else{
                        $('#frmchangepassword').submit();
                    }
                },
                error: function(){
                    swal('Could not edit data');
                }
            });
        }
    })
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@if(\Session::has('message'))
    {!! \Session::get('message') !!}
@endif