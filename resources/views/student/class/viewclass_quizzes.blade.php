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
				            <li>
				                <a href="/subjects/view/assignments/{{$class->id}}">             
				                    <i class="flaticon-exclamation"></i> Assessments
				                    <span class="badge badge-secondary float-right"></span>
				                </a>
				            </li>
				            <li class="active">
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
						<h3>Quizzes Management</h3>
						@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
							<div class="btn-group ml-auto">
								<button id="btnnewquiz" onclick="newQuiz()" class="btn btn-warning btn-sm">
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
										<th>Start Date</th>
										<th>End Date</th>
										<th>Points</th>
										<th>Response</th>
										<th>Action</th>
									</tr>
								</thead>
								<tbody>
									@foreach($quizzes as $row)
										<tr>
											<td>{{$row->title}}</td>
											<td>{{date("F jS, Y - h:i A", strtotime($row->start_date ))}}</td>
											<td>{{date("F jS, Y - h:i A", strtotime($row->end_date ))}}</td>
											<td>{{$row->passing_points}}</td>

											@if($_SESSION['role']->id != 4)
												<td>
													<div class="btn-group">
														<a href="/quizzes/viewresponse/{{$row->id}}?id_class={{$class->id}}" title="Add Response" class="btn btn-success btn-sm br-0"><i class="fas fa-eye"></i> Total Response: {{\DB::table('quizzes_response')->where('id_quizzes', $row->id)->count()}}</a>
													</div>
												</td>
											@endif

											
											@if($_SESSION['role']->id == 4)
												@if(\DB::table('quizzes_response')->where('id_quizzes', $row->id)->where('id_student', \Auth::user()->id_user)->count() == 1)
												<td>
													<div class="btn-group">
														<button title="Add Response" class="btn btn-success btn-sm br-0" onclick="addResponse('{{$row->id}}')"><i class="fas fa-hand-paper"></i> View Response</button>
													</div>
												</td>
												@else
												<td>
													<a title="Add Response" class=" btn-link text-info btn-sm br-0" onclick="addResponse('{{$row->id}}')"><i class="fa fa-plus"></i> Add Reponse</a>
												</td>
												@endif
											@endif
											

											@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
												<td>
													<div class="btn-group">
														<!-- <button title="Copy" class="btn btn-info btn-sm br-0" onclick="createCopy('{{$row->id}}')"><i class="far fa-copy"></i></button> -->
														<button title="Edit" class="btn btn-warning btn-sm br-0" onclick="getEdit('{{$row->id}}')"><i class="fa fa-edit"></i></button>
														<!-- <button title="Delete" class="btn btn-danger btn-sm br-0" onclick="getDelete('{{$row ->id}}','/assignments/delete')"><i class="fa fa-trash"></i></button> -->
													</div>
												</td>
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
<form action="/quizzes/sendresponse" method="POST" id="" enctype="multipart/form-data">
	@csrf
    <div class="modal" data-keyboard="false" data-backdrop="static" id="frmsendresponse" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="" role="document" style="margin: 1.5rem auto; width: 70%">									
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        Answering</span> 
                        <span class="fw-light">
                            Quiz
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">   
					<input type="hidden" name="id_class" id="id_class" value="{{$class->id}}">
					<input type="hidden" name="id" id="id_quiz" value="">	
                    <div class="row p-3" id="data_for_edit">
                        <div class="col-md-12 mb-2" id="error_msg">
                            <span class="text-danger"><b>Note: </b>Please read the instructions and questions carefully</span>
                        </div>
                        <div class="col-md-6">
                        	<p>
                        		<b>Title:</b>
                        		<span id="response_title"></span>
                        	</p>
                        </div>
                        <div class="col-md-6">
                        	<p>
                        		<b>Passing Points:</b>
                        		<span id="response_passing_points"></span>
                        	</p>
                        </div>
                        <div class="col-md-6">
                        	<p>
                        		<b>Start Date:</b>
                        		<span id="response_start_date"></span>
                        	</p>
                        </div>
                        <div class="col-md-6">
                        	<p>
                        		<b>End Date:</b>
                        		<span id="response_end_date"></span>
                        	</p>
                        </div>
                        <div class="col-md-12">
                        	<p>
                        		<b>Instructions:</b>
                        		<span id="response_instruction"></span>
                        	</p>
                        </div>
                        <div class="col-md-12">&nbsp;</div>

                        <div class="col-md-12" id="questionsField">
                        	<div class="table-responsive">
                        		<table id="multi-filter-select" class="display table table-striped table-hover" >
                        			<thead>
                        				<tr style="background-color: #00b0e9; color: white;">
                        					<th>Points</th>
                        					<th>Question</th>
                        					<th>Answer</th>
                        				</tr>
                        			</thead>
                        			<tbody id="response_quizitems">
                        			</tbody>
                        		</table>
                        	</div>
                        </div>
                        <input type="hidden" name="compiledanswers" id="compiledanswers">
                        <div class="col-md-12">
                        	<button type="button" id="btn_submitresponse" class="btn btn-primary" style="float:right">Submit</button>
                        </div>
                    </div>
            	</div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
	function addResponse(id){
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/fetch/quiz/'+id,
            async: false,
            cache: false,
            success: function(data){
                $('#id_quiz').val(data.id)
                $("#response_title").text(data.title);
                $("#response_start_date").text(data.start_date);
                $("#response_end_date").text(data.end_date);
                $("#response_passing_points").text(data.passing_points);
                $("#response_instruction").text(data.instruction);
                $("#response_quizitems").empty();
                if(data.question != ""){
                	var items = data.question.split('((end[]line))');
                	$.each(items, function(k, v){
                		if(k < items.length-1){
	                		var question = v.split('([(=)])')[0];
	                		var points = v.split('([(=)])')[2];
		                	$('#response_quizitems').append('<tr>'+
		                		'<td>'+points+'</td>'+
		                		'<td>'+question+'</td>'+
		                		'<td>'+
		                			'<input type="text" class="form-control" style="width: 80%; height: 70%!important">'+
		                		'</td>'+
		                	'</tr>')
                		}
                	})

                	$.ajax({
                	    type: 'ajax',
                	    method: 'get',
                	    url: '/fetch/quizresponse',
                	    data: {
                	        "id_student": '<?php echo $_SESSION["user_profile"]->id; ?>',
                	        "id": id,
                	    },
                	    async: false,
                	    success: function(data){
        	    		  	$.each($('#response_quizitems tr'), function(k, v){
        	    		  		var A = data.response.split('((end[]line))');
        	    		  		$(v).find("input").val(A[k]);
        	    		  		$(v).find("input").attr('disabled', true);
        	    		  	})
                	    }
                	})

                }
                else{
                	$('#response_quizitems').append('<tr id="norow_default">'+
                		'<td colspan="3" class="text-center" style="color: gray">No Data Available</td>'+
                	'</tr>')
                }
            },
            error: function(){
                swal('Something went wrong');
            }
        });
		$('#frmsendresponse').modal('show');
	}
	$('#btn_submitresponse').click(function(){
		swal({
		  title: "Submit Answer?",
		  text: "You will not be able to update your answers once submitted.",
		  icon: "warning",
		  buttons: [
		    'No',
		    'Yes'
		  ],
		  dangerMode: true,
		}).then(function(isConfirm) {
		  if (isConfirm) {

		  	$.each($('#response_quizitems tr'), function(k, v){
		  		var A = $(v).find("input").val();
	  			$('#compiledanswers').val($('#compiledanswers').val()+ A + '((end[]line))');
		  	})
		    $.ajax({
		        type: 'ajax',
		        method: 'post',
		        url: '/quizzes/submitresponse',
		        data: {
		            "_token": "{{ csrf_token() }}",
		            "id_class": $('#id_class').val(),
		            "id": $('#id_quiz').val(),
		            "compiledanswers": $('#compiledanswers').val(),
		        },
		        async: false,
		        success: function(data){
				    swal({
				      title: data.title,
				      text: data.msg,
				      icon: data.icon
				    }).then(function() {
				        //RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
				        if(data.icon != "error"){
					        location.reload();
				        }
				    });
		        },
		        error: function(){
		            swal('Could not edit data');
		        }
		    });
		  }
		})
	})
</script>
@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
<!-- Modal -->
<form action="/quizzes/add" method="POST" id="myForm" enctype="multipart/form-data">
	<input type="hidden" name="id_class" value="{{$class->id}}">
	@csrf
    <div class="modal" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="" role="document" style="margin: 1.5rem auto; width: 70%">									
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
                            <span class="text-danger">Please fill-up all the required (*) fields</span>
                        </div>    
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Quiz Title</label>
                                <input  type="hidden" name="id" id="id" class="form-control">
                                <input  type="text" name="title" id="title" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Start Date</label>
                                <input  type="datetime-local" name="start_date" id="start_date" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> End Date</label>
                                <input  type="datetime-local" name="end_date" id="end_date" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Passing Points</label>
                                <input  type="number" name="passingpoints" id="passingpoints" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span>  Instruction </label>
                                <textarea name="instruction" id="instruction" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                        </div>
                        <div class="col-md-12">
	                        <h4>Add Questions</h4>
	                        <div class="col-md-12 row">
		                        <div class="col-md-5 col-sm-12">
		                            <div class="form-group form-group-default">
		                                <label><span class="text-danger"></span>Question</label>
		                                <input  type="text" id="quizquestion" class="form-control">
		                            </div>
		                        </div>
		                        <div class="col-md-3 col-sm-12" id="answerfield">
		                            <div class="form-group form-group-default">
		                                <label><span class="text-danger"></span>Answer</label>
		                                <input  type="text" id="quizanswer" class="form-control">
		                            </div>
		                        </div>
		                        <div class="col-md-2 col-sm-12">
		                            <div class="form-group form-group-default">
		                                <label><span class="text-danger"></span>Points</label>
		                                <input  type="number" id="quizpoints" class="form-control">
		                            </div>
		                        </div>
		                        <div class="col-md-2 col-sm-12" style="padding-top: 15px;">
		                        	<button class="btn btn-primary btn-sm" onclick="postquiz()" type="button">Post</button>
		                        </div>
	                        </div>
                        </div>
                        <div class="col-md-12">&nbsp;</div>
                        <div class="col-md-12" id="questionsField">
                        	<div class="table-responsive">
                        		<table id="multi-filter-select" class="display table table-striped table-hover" >
                        			<thead>
                        				<tr style="background-color: #00b0e9; color: white;">
                        					<th>Question</th>
                        					<th>Answer</th>
                        					<th>Points</th>
                        					<th>Action</th>
                        				</tr>
                        			</thead>
                        			<tbody id="quizitems">
                        				<tr id="norow_default">
                        					<td colspan="4" class="text-center" style="color: gray"><b>No Data Available</b></td>
                        				</tr>
                        			</tbody>
                        		</table>
                        	</div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer no-bd">
                	<input type="hidden" name="question" id="compiledquestion">
                    <button type="button" id="btns3save" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
                    <button type="button" data-dismiss="modal" class="btn btn-danger">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script type="text/javascript">
	function closeaddmodal(){
		$('#addRowModal').modal('hide');
	}
	function newQuiz(){
		$("#id").val('');
		$("#title").val('');
		$("#start_date").val('');
		$("#end_date").val('');
		$("#passingpoints").val('');
		$("#instruction").val('');
		$('#quizquestion').val('');
		$('#quizanswer').val('');
		$('#quizpoints').val('');
		$('#compiledquestion').val('');
		$('#quizitems').empty();
		$('#quizitems').append('<tr id="norow_default">'+
			'<td colspan="4" class="text-center" style="color: gray">No Data Available</td>'+
		'</tr>')
		$('#addRowModal').modal('show');
	}
	function removeitem(e){
		$(e).closest('tr').remove();
		if($('#quizitems tr').length == 0){
			$('#quizitems').append('<tr id="norow_default">'+
				'<td colspan="4" class="text-center" style="color: gray">No Data Available</td>'+
			'</tr>')
		}
	}
	function getEdit(id){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Edit Quiz');
		$('#myForm').attr('action','/quizzes/update');

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/quiz/'+id,
			data:{
				id:id,
				},
			async: false,
			success: function(data){
				$("#title").val(data.title);
				$("#start_date").val(data.start_date);
				$("#end_date").val(data.end_date);
				$("#passingpoints").val(data.passing_points);
				$("#instruction").val(data.instruction);
                $("#quizitems").empty();
                if(data.question != ""){
                	var items = data.question.split('((end[]line))');
                	$.each(items, function(k, v){
                		if(k < items.length-1){
	                		var question = v.split('([(=)])')[0];
	                		var answer = v.split('([(=)])')[1];
	                		var points = v.split('([(=)])')[2];
		                	$('#quizitems').append('<tr>'+
		                		'<td>'+question+'</td>'+
		                		'<td>'+answer+'</td>'+
		                		'<td>'+points+'</td>'+
		                		'<td>'+
									'<button class="btn btn-danger btn-sm" onclick="removeitem(this)"><i class="fa fa-trash"></i></button>'+
		                		'</td>'+
		                	'</tr>')
                		}
                	})
                }
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	}
	function postquiz(){
		var quizquestion = $('#quizquestion').val();
		var quizanswer = $('#quizanswer').val();
		var quizpoints = $('#quizpoints').val();
		if(quizquestion != "" && quizpoints != ""){
			$('#norow_default').remove();
			$('#quizitems').append('<tr>'+
				'<td>'+quizquestion+'</td>'+
				'<td>'+quizanswer+'</td>'+
				'<td>'+quizpoints+'</td>'+
				'<td>'+
					'<button class="btn btn-danger btn-sm" onclick="removeitem(this)"><i class="fa fa-trash"></i></button>'+
				'</td>'+
			'</tr>')
		}
		else{
			toastr.warning('Question and points must not be empty');
		}
	}
	$('#btns3save').click(function(){
		$.each($('#quizitems tr'), function(k, v){
			var Q = $(v).find("td:eq(0)").text();
			var A = $(v).find("td:eq(1)").text();
			var P = $(v).find("td:eq(2)").text();
			if(A == "" && P == "" && Q == "No Data Available"){
				$('#compiledquestion').val('');
			}
			else{
				$('#compiledquestion').val($('#compiledquestion').val() + Q + '([(=)])' + A + '([(=)])' + P + '((end[]line))');
				$('#myForm').submit();
			}
		})
	})
</script>
@endif
@endsection
@section('footer')
@endsection
<script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.min.js"></script>
<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
@if(\Session::has('message'))
    {!! \Session::get('message') !!}
@endif