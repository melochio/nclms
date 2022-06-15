@extends('layout.master')
@section('header')
@endsection
@section('sidepanel')
@endsection
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
						<h3>Assignment Management</h3>

						@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
							<div class="btn-group ml-auto">
								<button id="btninvite" onclick="newAssignment()" class="btn btn-warning btn-sm">
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
										<th>Title</th>
										<th>Points</th>
										<th>Start Date</th>
										<th>End Date</th>
										<th>Response</th>
										<th>Actions</th>
									</tr>
								</thead>
								<tbody>
									@foreach($assignments as $row)
										<tr>
											<td>{{$row->title}} </td>
											<td>{{$row->points}}</td>
											<td>{{date("F jS, Y", strtotime($row->start_date ))}}</td>
											<td>{{date("F jS, Y", strtotime($row->end_date ))}}</td>
											@if($_SESSION['role']->id != 4)
												
												<td>
													<div class="btn-group">
														<a href="/subjects/view/assignments/{{$class->id}}/view?assignment={{$row->id}}" title="Add Response" class="btn btn-success btn-sm br-0"><i class="fas fa-eye"></i> Total Response: {{\DB::table('assignment_response')->where('id_assignment', $row->id)->count()}}</a>
													</div>
												</td>
											@endif
											@if($_SESSION['role']->id == 4)
												@if(strtotime($row->end_date) < strtotime(date('Y-m-d')))
													<td><span class="badge badge-dark" style="cursor: default; background: gray"><smal>Timeline Ended</smal></span></td>
												@else
													@if(strtotime($row->start_date) > strtotime(date('Y-m-d')))
														<td><span class="badge badge-dark" style="cursor: default; background: gray"><smal>Timeline doesn't meet</smal></span></td>
													@else
														@if(\DB::table('assignment_response')->where('id_assignment', $row->id)->where('id_student', \Auth::user()->id_user)->count() == 1)
														<td>
															<div class="btn-group">
																<button title="Add Response" class="btn btn-success btn-sm br-0" onclick="addResponse('{{$row->id}}')"><i class="fas fa-hand-paper"></i> View Response</button>
															</div>
														</td>
														@else
														<td>
															<a title="Add Response" class=" btn-link text-info btn-sm br-0" style="cursor: pointer" onclick="addResponse('{{$row->id}}')"><i class="fa fa-plus"></i> Add Reponse</a>
														</td>
														@endif
													@endif
												@endif
											@endif
											

											@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
												@if($view_type != 'bin')
													<td>
														<div class="btn-group">
															<!-- <button title="Copy" class="btn btn-info btn-sm br-0" onclick="createCopy('{{$row->id}}')"><i class="far fa-copy"></i></button> -->
															<button title="Edit" class="btn btn-warning btn-sm br-0" onclick="getEdit('{{$row->id}}')"><i class="fa fa-edit"></i></button>
															<button title="Delete" class="btn btn-danger btn-sm br-0" onclick="getDelete('{{$row ->id}}','/subjects/view/assignments/delete/assignment')"><i class="fa fa-trash"></i></button>
														</div>
													</td>
												@else
													<td>
														<div class="btn-group">
															<button class="btn btn-info btn-sm br-0"onclick="restoreassignment('{{$row ->id}}','/assignment/restore')"><i class="fa fa-recycle"></i> Restore</button>
														</div>
													</td>
												@endif
											@endif

											@if($_SESSION['role']->id == 4)
												<td>
													<div class="btn-group">
														<button title="View" class="btn btn-warning btn-sm br-0" onclick="getView('{{$row->id}}')"><i class="fa fa-eye"></i></button>
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
<!-- Modal -->
<form action="/driver_type/add" method="POST" id="myFormResponse" enctype="multipart/form-data">
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
                    <div class="row p-3" id="data_for_edit">
                        <div class="col-md-12 mb-2" id="error_msg">
                            <div class="alert alert-warning"><span class="text-danger add-response-form-msg">Please fill-up all the required (*) fields</span></div>
                        </div>       
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Your Reponse </label>
                                <input type="hidden" name="id_assignment" id="id_ass_response">
                                <input type="hidden" name="ass_response_action" id="ass_response_action">
                                <textarea name="response" id="response" cols="30" rows="8" class="form-control" required></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger"></span> Attached a file (Optional)</label>
                                <input  type="file" class="form-control" name="userfile" id="userfile" placeholder="">
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="response_view_file"><b>Attached File:</b> <a href="#" class="attached_file_ass_response" download><span class="attached_file_ass_response_text"></span></a> <br></div>
                            
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
<!-- Modal -->
<div class="modal fade" data-keyboard="false" data-backdrop="static" id="ViewaddRowModal" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">									
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
                <div class=" p-3">
                    <p><b>Title:</b> <span class="title"></span> </p>
                    <p><b>Instruction:</b>    <span class="instruction"></span> </p> </p>
                    <p><b>Start Date:</b> <span class="start_date"></span> </p> </p>
                    <p><b>Due Date:</b> <span class="end_date"></span> </p> </p>
                    <p><b>Points:</b> <span class="points"></span> </p> </p>
                    <b>Attached File:</b> <a class="attached_file" download></a> <br>
                </div>
            </div>
            <div class="modal-footer no-bd">
                <button type="button" class="btn btn-success" data-dismiss="modal">Done</button>
            </div>
        </div>
    </div>
</div>
@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
<!-- Modal -->
<form action="/subjects/view/assignments/new/assignment" method="POST" id="myForm" enctype="multipart/form-data">
	@csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">									
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        New</span> 
                        <span class="fw-light">
                            Assignment
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">          
                    <div class="row p-3" id="data_for_edit">
                        <div class="col-md-12 mb-2" id="error_msg">
                            <span class="text-danger">Please fill-up all the required (*) fields</span>
                        </div>    
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Assignement Title</label>
                                <input  type="hidden" name="id_class" id="id_class" value="{{$class->id}}" class="form-control">
                                <input  type="hidden" name="id" id="id" value="" class="form-control">
                                <input  type="text" name="title" id="title" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Start Date</label>
                                <input  type="date" name="start_date" id="start_date" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Due Date</label>
                                <input  type="date" name="end_date" id="end_date" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Points</label>
                                <input  type="text" name="points" id="points" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Upload a file</label>
                                <input  type="file" class="form-control" name="userfile" id="assignmentfrmfile" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span>  Instruction </label>
                                <textarea name="instruction" id="instruction" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                    <button type="submit" id="btnssave" class="btn btn-success"><i class="fa fa-save"></i> Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
	function newAssignment(){
		$('#myForm').attr('action','/subjects/view/assignments/new/assignment');
		$("#assignmentfrmfile").attr('required','');
		$("#created_by").val('');
		$("#title").val('');
		$("#assignmentfrmfile").val('');
		$("#points").val('');
		$("#start_date").val('');
		$("#end_date").val('');
		$("#instruction").val('');
		$('#addRowModal').modal('show');
	}
	function getEdit(id){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Edit Assessment');
		$("#assignmentfrmfile").removeAttr('required');
		$('#myForm').attr('action','/subjects/view/assignments/update/assignment');

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/assessment/'+id,
			data:{
				id:id,
				},
			async: false,
			success: function(data){
				$("#id").val(data.id);
				$("#created_by").val(data.created_by);
				$("#title").val(data.title);
				$("#points").val(data.points);
				$("#start_date").val(data.start_date);
				$("#end_date").val(data.end_date);
				$("#instruction").val(data.instruction);
				$('#assignmentfrmfile').val('');
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	}
	function getDelete(id,url){
		swal({
		  title: "Remove Assignment?",
		  text: "Removing assignments will stop Students from submitting their responses!",
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
					id: id
				},
				async: false,
				success: function(data){
					
				},
				error: function(){
					swal('Could not edit data');
				}
			});

			swal({
			  title: 'Assignment has been successfully removed!',
			  text: '',
			  icon: 'success'
			}).then(function() {
				//RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
				location.reload();
			});
		  }
		})
	};
    function restoreassignment(id, url){
        swal({
          title: "Restore Assignment?",
          text: "Restoring assignments will allow your students from submitting responses.",
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
                    id: id
                },
                async: false,
                dataType: 'text',
                success: function(data){
                    
                },
                error: function(){
                    swal('Could not edit data');
                }
            });

            swal({
              title: 'Assignment Restored!',
              text: 'Assignment has been successfully restored!',
              icon: 'success'
            }).then(function() {
                //RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
                location.reload();
            });
          }
        })
    }
</script>
@endif
<script type="text/javascript">
	function addResponse(id){
		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/assessment_response/'+id,
			data: { id_student: <?php echo $_SESSION['user_profile']->id; ?>},
			async: true,
			success: function(data){
				if(data != ""){
					$(".add-response-form-msg").text('To update response, update the form and click Update button.');
					$("#btnssave_response").text('Update');
					$("#ass_response_action").val('update');
					$("#id_ass_response").val(data.id);
					$("#response").val(data.response);
					$(".attached_file_ass_response_text").text(data.attached_file);
					$(".attached_file_ass_response").attr("href", "/uploads/assignments/response/"+id+"/"+data.attached_file);
					$(".response_view_file").show();
				}else{
					$(".add-response-form-msg").text('Please fill-up all the required (*) fields');
					$("#btnssave_response").text('Submit');
					$("#ass_response_action").val('save');
					$('#response').val('');
					$(".response_view_file").hide();
				}
				$('#ResponseaddRowModal').find('.modal-title').text('Add Response to Assignment');
				$('#myFormResponse').attr('action','/subjects/view/assignments/'+id);
				$("#id_ass_response").val(id);
				$('#ResponseaddRowModal').modal('show');
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	};
	$('form').on('submit', function(e){
		e.preventDefault();
		if($('#response').val() != ""){
			$(this).submit();
		}
		else{
			toastr.error('Required fields must not be empty!');
		}
	})
	function getView(id){
		$('#ViewaddRowModal').modal('show');
		$('#ViewaddRowModal').find('.modal-title').text('View Assignment');

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/assessment/'+id,
			async: false,
			success: function(data){
				$(".id").text(data.id);
				$(".created_by").text(data.created_by);
				$(".title").text(data.title);
				$(".attached_file").text(data.attached_file);
				$(".points").text(data.points);
				$(".start_date").text(data.start_date);
				$(".end_date").text(data.end_date);
				$(".instruction").text(data.instruction);
				$(".is_assign_to_class").text(data.is_assign_to_class);
				$(".is_assign_to_specific_student").text(data.is_assign_to_specific_student);
				$(".attached_file").attr("href", "/uploads/assignments/"+id+"/"+data.attached_file,'_blank');
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