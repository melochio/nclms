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
			                <li>
			                    <a href="/subjects/view/classpeople/{{$class->id}}">
			                        <i class="flaticon-users"></i> Class People
			                    </a>
			                </li>
				            <li class="active">
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
						<h3>Assignment Responses</h3>
					</div>
					<div class="card-body">
                        <div class="btn-block bg-success text-white">Assignment Details</div>
                            <div class="jumbotron">
                                <div class="row">
                                    <div class="col-md-4">
                                        <p>
                                            <b>Title:</b> {{$assignment->title}} <br>
                                            <b>Points:</b> {{$assignment->points}} <br>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <b>Start Date:</b> {{$assignment->start_date}} <br>
                                            <b>Due Date:</b> {{$assignment->end_date}} <br>
                                        </p>
                                    </div>
                                    <div class="col-md-4">
                                        <p>
                                            <b>Attached File:</b> <a href="/uploads/assignments/{{$assignment->id}}/{{$assignment->attached_file}}">{{$assignment->attached_file}}</a> <br>
                                        </p>
                                    </div>
                                    <div class="col-md-12">
                                        <p>
                                            <b>Instruction:</b> {{$assignment->instruction}}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
						<div class="table-responsive">
							<table id="multi-filter-select" class="display table table-striped table-hover" >
								<thead>
									<tr>
										<th>Student</th>
										<th>Response</th>
										<th>Attached File</th>
										<th>Your Remarks</th>
										<th>Grade</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($responses as $row)
										<tr>
											<td>{{$row->last_name}}, {{$row->first_name}}</td>
											<td>{{$row->response}}</td>
											<td><a href="/uploads/assignments/response/{{$row->id_assignment}}/{{$row->attached_file}}">{{$row->attached_file}}</a></td>
											<td>{{$row->teacher_remarks}}</td>
											<td>{{$row->grade}}</td>
											@if($_SESSION['role']->id != 4)
												<td>
													<div class="btn-group">
														<a title="Add Remarks" onclick="addResponse({{$row->id_assignment}},  {{$row->id_student}})" class="btn btn-success btn-sm br-0"><i class="fas fa-plus"></i> Add Remarks</a>
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
<form action="/driver_type/add" method="POST" id="myFormResponse">
	@csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="ResponseaddRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog" role="document">									
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        New</span> 
                        <span class="fw-light">
                            Row
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                	<input type="hidden" name="id_response" id="id_response">
                	<input type="hidden" name="id_student" id="id_student">
                    <div class="row p-3" id="data_for_edit">
                        <div class="col-md-12 mb-2" id="error_msg">
                            <div class="alert alert-warning"><span class="text-danger add-response-form-msg">Please fill-up all the required (*) fields</span></div>
                        </div>       
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Your Remarks </label>
                                <textarea name="remarks" id="remarks" cols="30" rows="8" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Grade</label>
                                <input  type="number" name="grade" id="grade" step=".01" max="100" min="0" class="form-control" placeholder="" required>
                            </div>
                        </div>                        
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="submit" id="btnssave_response" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
	function addResponse(id, id_student){
		$('#ResponseaddRowModal').modal('show');
		$('#ResponseaddRowModal').find('.modal-title').text('Add Remarks to Assignment Response');
		$('#myFormResponse').attr('action','/subjects/view/assignments/postRemark');
		$('#id_response').val(id);
		$('#id_student').val(id_student);
		
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/assessment_response/'+id,
			data: { id_student: id_student},
			async: false,
			success: function(data){
				$(".add-response-form-msg").text('Please fill-up all the required (*) fields');
				$("#btnssave_response").text('Submit');
				$("#grade").val(data.grade);
				$("#remarks").val(data.teacher_remarks);
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	};
</script>
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@if(\Session::has('message'))
    {!! \Session::get('message') !!}
@endif
@endsection
@section('footer')
@endsection