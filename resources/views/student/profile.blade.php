@extends('layout.master')
@section('header')
@stop
@section('sidepanel')
@stop
@section('body')
<div class="main-panel">
	<div class="content">
		<div class="page-inner">
			<form action="/profile" method="POST" id="myForm" enctype="multipart/form-data">
				@csrf
				<div class="row">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<div class="d-flex align-items-center">
									<h4 class="card-title">MY PROFILE</h4>
									<button type="submit" id="btnsave" class="btn btn-info btn-round ml-auto">
										<i class="fa fa-save"></i>
										Update
									</button>
								</div>
							</div>
							<div class="card-body">
								<div class="row p-3" id="data_for_edit">                      
									<div class="row ">
										<div class="col-md-3">

											<div class="uploaded_image">
												<img id="img_preview" src="/uploads/dp/<?php echo empty($_SESSION['user_profile']->picture) ? 'default_pic.png' : $_SESSION['user_profile']->picture ?>" class="img-thumbnail w-100 profilepic" alt="">
											</div>
											<button type="button" class="btn btn-info btn-sm btn-block"  style="display:block;height:30px;" onclick="document.getElementById('file').click()">Browse</button>
											<input type='file' id="file" style="display:none" name="file">
											<input type="hidden" id="temp_photo_arr" name="picture" value="<?= $_SESSION['user_profile']->picture?>">
										</div>
										<div class="col-md-9">
											<div class="row">
												<div class="col-md-12">
													<div class="card">
														<div class="card-header">
															<div class="d-flex align-items-center">
																<h4 class="card-title">BASIC DETAILS</h4>
															</div>
														</div>
														<div class="card-body">
															<div class="row">
																<div class="col-sm-4">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> First Name</label>
																		<input  type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" value="{{ $_SESSION['user_profile']->first_name}}" required>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> Middle Name</label>
																		<input  type="text" name="middle_name" id="middle_name" class="form-control" placeholder="Middle name" value="{{$_SESSION['user_profile']->middle_name}}"   required>
																	</div>
																</div>
																<div class="col-sm-4">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> Last Name</label>
																		<input  type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" value="{{$_SESSION['user_profile']->last_name}}"   required>
																	</div>
																</div>

																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> Email</label>
																		<input  type="email" name="email" id="email" class="form-control" placeholder="email" value="{{$_SESSION['user_profile']->email}}"  required>
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> Mobile Number</label>
																		<input  type="text" name="contact" maxlength="11" id="contact" class="form-control" placeholder="Contact" onkeyup="this.value=this.value.replace(/[^\d]/,'')" value="{{$_SESSION['user_profile']->contact}}" required>
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label><span class="text-danger">*</span> Address</label>
																		<input  type="text" name="address" id="address" class="form-control"  value="{{$_SESSION['user_profile']->address}}"  required>
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

												<div class="col-md-12">
													<div class="card">
														<div class="card-header">
															<div class="d-flex align-items-center">
																<h4 class="card-title">LOGIN CREDENTIALS</h4>
															</div>
														</div>
														<div class="card-body">
															<div class="row">
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label>Username</label>
																		<input  type="text" name="username" id="username" value="{{\Auth::user()->username}}" class="form-control" >
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label>Current Password</label>
																		<input  type="password" name="current_password" id="current_password" class="form-control" >
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label>New Password</label>
																		<input  type="password" name="new_password" id="new_password" class="form-control" >
																	</div>
																</div>
																<div class="col-sm-12">
																	<div class="form-group form-group-default">
																		<label>Confirm Password</label>
																		<input  type="password" name="confirm_password" id="confirm_password" class="form-control" >
																	</div>
																</div>
															</div>
														</div>
													</div>
												</div>

											</div>
										</div>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</form>
		</div>
	</div>
</div>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@if(\Session::has('message'))
    {!! \Session::get('message') !!}
@endif
<script>
	function imagePreview(fileInput) {
		var f = document.getElementById("file").files[0];
		var fsize = f.size||f.fileSize;
		if(fsize > 8000000)
		{
		alert("Image File Size is very big");
		}
		else
		{
		    if (fileInput.files && fileInput.files[0]) {
		        var fileReader = new FileReader();
		        fileReader.onload = function (event) {
		            $('#img_preview').attr('src', event.target.result);
		        };
		        fileReader.readAsDataURL(fileInput.files[0]);
		    }
		}
	}
	$('#file').change(function(){
		imagePreview(this);
	})
	$('form').on('submit', function(e){
	    e.preventDefault();
	    var username = $('#username').val();
	    var password = $('#new_password').val();
	    var repassword = $('#confirm_password').val();
	    var current_pwd = $('#current_password').val();
	    var first_name = $('#first_name').val();
        var last_name = $('#last_name').val();
        var middle_name = $('#middle_name').val();
        var email = $('#email').val();
        var contact = $('#contact').val();
        var address = $('#address').val();
	    if(first_name != "" && last_name != "" && middle_name != "" && email != "" && contact != "" && address != ""){
		    if(current_pwd != ""){
		    	if(username != ""){
					$.ajax({
						url: "/hashcheck?userInput="+current_pwd,
						method:"get",
						contentType: false,
						cache: false,
						processData: false,
						success:function(data){
							if(data == "false"){
						        toastr.error('Incorrect current password!');
							}
						}
					});
					if(password != ""){
					    if(password != repassword){
					        toastr.error('Password does not match!');
					    }
					    else if(password.length < 6){
					        toastr.error('Password must be 6 characters above!');
					    }
					    else if(password.length >= 16){
					        toastr.error('Password must be 16 characters below!');
					    }
					    else{
				            $(this).submit();
					    }
					}
					else{
				        toastr.error('New password must not be empty!');
					}
		    	}
				else{
			        toastr.error('Username must not be empty!');
				}
		    }
		    else{
		    	$(this).submit();
		    }
	    }
	    else{
	        toastr.error('Required fields must not be empty!');
	    }
	})
</script>
@endsection
@section('footer')
@endsection