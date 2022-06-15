@extends('layout.master')
@section('header')
@stop
@section('sidepanel')
@stop
@section('body')

<style>
	.jumbotron {
    	padding: 1rem 1rem;
	}
</style>
<div class="main-panel">
	<div class="container-full mt-5">
		<div class="page-inner page-inner-fill">
			<div class="page-with-aside mail-wrapper bg-white">
				<div class="page-aside bg-grey1">
				    <div class="aside-header">
				        <div class="title">{{$class->class_name}}</div>
				        <div class="description">{{$class->description}}</div>
				        <a class="btn btn-primary toggle-email-nav" data-toggle="collapse" href="#email-app-nav" role="button" aria-expanded="false" aria-controls="email-nav">
				            <span class="btn-label">
				                <i class="icon-menu"></i>
				            </span>
				            Subject Menu
				        </a>
				    </div>
				    <div class="aside-nav collapse" id="email-app-nav">
				        <ul class="nav">
				            <li>
				                <a href="/subjects/view/dashboard/{{$class->id}}">
				                    <i class="flaticon-laptop"></i> Dashboard
				                </a>
				            </li>
			                <li class="active">
			                    <a href="/subjects/view/classpeople/{{$class->id}}">
			                        <i class="flaticon-users"></i> Class People
			                    </a>
			                </li>
				            <li class="">
				                <a href="/subjects/view/assignments/{{$class->id}}">             
				                    <i class="flaticon-exclamation"></i> Assessments
				                    <span class="badge badge-secondary float-right"></span>
				                </a>
				            </li>
				            <li>
				                <a href="/subjects/view/quizzes/{{$class->id}}">
				                    <i class="flaticon-envelope-3"></i> Quizzes
				                </a>
				            </li>
				            <li>
				                <a href="/subjects/view/materials/{{$class->id}}">
				                    <i class="flaticon-price-tag"></i> Learning Materials
				                </a>
				            </li>
				            <li>
				                <a data-toggle="collapse" href="#sys_class_bin" class="collapsed" aria-expanded="false">
				                    <i class="flaticon-interface-5"></i>Archived<p></p>
				                    <span class="caret"></span>
				                </a>
				                <div class="collapse" id="sys_class_bin" style="">
				                    <ul class="nav nav-collapse">
				                        <li>
				                            <a href="/subjects/view/assignments/bin/{{$class->id}}">
				                                <span class="sub-item">Assessments</span>
				                            </a>
				                        </li>
				                        <li>
				                            <a href="/subjects/view/materials/bin/{{$class->id}}">
				                                <span class="sub-item">Learning Materials</span>
				                            </a>
				                        </li>
				                    </ul>
				                </div>
				            </li>
				        </ul>
				    </div>
				</div>
				<div class="page-content mail-content">
					<div class="inbox-head d-lg-flex d-block">
						<h3>Class People</h3>
						@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
							<div class="btn-group ml-auto">
								<button id="btninvite" onclick="inviteUser()" class="btn btn-warning btn-sm">
									<i class="fa fa-plus"></i>
									Add
								</button>
							</div>
						@endif
					</div>
					<div class="card-body">
						<div class="table-responsive">
							<table id="multi-filter-select" class="display table table-striped table-hover" >
								<thead>
									<tr>
										<th>Name</th>
										<th>Role</th>
										<th>Gender</th>
										<th>Email</th>
										<th>Contact</th>
										<?php
										if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3){
											?>
											<th>Option</th>
											<?php
										}
										?>
										
									</tr>
								</thead>
								<tbody>
									@foreach($users as $info)
									<tr>
										<td>{{ucfirst($info->last_name)}},{{ucfirst($info->first_name)}}
										{{ucfirst($info->middle_name)}}</td>
										<td>
											@if(ucfirst(substr($info->role,0,-1)) == "Student")
												<span class="badge badge-success">{{ucfirst(substr($info->role,0,-1))}}</span>
											@else
												<span class="badge badge-warning">{{ucfirst(substr($info->role,0,-1))}}</span>
											@endif
										</td>
										<td>{{$info->gender}}</td>
										<td>{{$info->email}}</td>
										<td>{{$info->contact}}</td>
										@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
											<td>
												<div class="btn-group">
													<button title="Remove" class="btn btn-danger btn-sm br-0" onclick="removeuser('{{$info ->id}}','/subjects/view/removeuserfromclass')"><i class="fa fa-trash"></i> Remove</button>
												</div>
											</td>
										@endif
									</tr>
									@endforeach
								</tbody>
							</table>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>
@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
<!-- Modal -->
<form action="/subjects/view/classpeople" method="POST" id="myForm2">
	@csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">									
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        New</span> 
                        <span class="fw-light">
                            Student/Instructor
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">          
                    <div class="row ">
                        <div class="col-md-12">
                            <div class="row">
                                <div class="col-md-12">
                                	<input type="hidden" name="id_class" id="id_class" value="{{$class->id}}">
                                    <div class="form-group">
										@if($_SESSION['role']->id == 1)
	                                        <label><span class="text-danger"><span class="text-danger">*</span></span> Input Student/Teacher ID #</label>
										@else
	                                        <label><span class="text-danger"><span class="text-danger">*</span></span> Input Student ID #</label>
										@endif
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="account_id" id="account_id2" 
                                            placeholder="Input ID #" aria-label="" aria-describedby="basic-addon1">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-success btn-border" onclick="searchAccount()" type="button"><i class="fa fa-search"></i></button>
                                            </div>
                                        </div>
                                    </div>
                                    <span class="msg"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="button" onclick="frminvitesubmit()" id="btnInvite2" class="btn btn-success"><i class="fa fa-save"></i> Invite</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
	function inviteUser(){
		$('#addRowModal').modal('show');
	}
	function searchAccount(){
		let account_id = $("#account_id2").val();
		if(account_id == ''){
			swal('Please input ID # first','','warning');
			return false;
		}else{
			$.ajax({
				type: 'ajax',
				method: 'get',
				url: '/fetch/verifyuserbyid/'+account_id,
				async: false,
				success: function(data){
					if(data.count > 0){
						$(".msg").html('<p class="text-success">Account Found: <b>'+data.user.last_name+', '+data.user.first_name+'</p></b>');
					}
					else{
						$(".msg").html('<p class="text-danger">There is no account associated with this ID # <b>'+account_id+'</p></b>');
					}
					
				},
				error: function(){
					swal('Something went wrong');
				}
			});
		}
	}
	function frminvitesubmit(){
		console.log('sasd');
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/checkclasspeople/',
			data: {
				id_class: $('#id_class').val(),
				account_id: $('#account_id2').val(),
			},
			async: false,
			success: function(data){
				if(data > 0){
					$(".msg").html('<p class="text-danger">Student/Instructor is already in this class.</p>');
				}
				else{
					$('#myForm2').submit();
				}
			}
		});
	}

	function removeuser(id,url){
		swal({
		  title: "Do you want to remove this Student/Instructor?",
		  text: "",
		  icon: "warning",
		  buttons: [
			'No',
			'Yes'
		  ],
		  dangerMode: true,
		}).then(function(isConfirm) {
		  if (isConfirm) {

			$.ajax({
				type: 'ajax',
				method: 'post',
				url: url,
				data: {
			        "_token": "{{ csrf_token() }}",
					id_student: id,
					id_class: $('#id_class').val(),
				},
				async: false,
				dataType: 'text',
				success: function(data){
					
				},
				error: function(){
					swal('Could not remove user');
				}
			});

			swal({
			  title: 'Removed Successfully!',
			  text: '',
			  icon: 'success'
			}).then(function() {
				location.reload();
			});
		  }
		})
	};
</script>
@endif
@endsection
@section('footer')
@endsection