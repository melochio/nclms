@extends('layout.master')
@section('header')
@endsection
@section('sidepanel')
@endsection
@section('body')
<style>
.card-annoucement .card-body {
    padding: 17px 9px !important;
}
.card-annoucement .card-opening {
    font-size: 20px !important;
}
</style>

	<div class="main-panel">
		<div class="content">
			<div class="page-inner">
				<div class="row row-card-no-pd">
					<div class="col-md-12">
						<div class="card">
							<div class="card-header">
								<div class="card-head-row">
									<h4 class="card-title">List of Subjects</h4>
									<?php
									if($_SESSION['role']->id == 1){
										?>
										<button id="btnAdd" class="btn btn-warning btn-round ml-auto">
											<i class="fa fa-plus"></i>
											Create
										</button>
										<?php
									}
									?>
								
								</div>
							</div>
							<div class="card-body">
								<div class="row mb-1">
                                    @foreach($classes as $row)
										<div class="col-md-4 mb-3">
											<div class="card card-info card-annoucement card-round">
												<div class="card-body text-center">
													@if($_SESSION['role']->id == 1)
													<i class="fa fa-edit" onclick="getEdit('{{$row->class_id}}')" style="position: absolute; top: 12%; left:  83%; float: right; cursor: pointer;"></i>
														@if($row->del_status == 0)
														<i class="fa fa-retweet" onclick="enableRecord('{{$row->class_id}}', '/subjects/enable')" style="position: absolute; top: 12%; color: #00eb00;left:  90%; float: right; cursor: pointer;"></i>
														@else
														<i class="fa fa-trash" onclick="disableRecord('{{$row->class_id}}', '/subjects/disable')" style="position: absolute; top: 12%; color: #d94040; left:  90%; float: right; cursor: pointer;"></i>
														@endif
													@endif
													<div class="card-desc">Class Code: {{$row->class_id}}</div>
													<div class="mt--3 card-opening "><b>{{$row->class_name}}</b></div>
													<div class="card-desc">
														{{$row->day}}<br> {{$row->time}}
													</div>
													@if($_SESSION['role']->id > 3)
														@if($row->del_status == 0)
															<div class="card-detail">
																<button href="#" class="btn btn-light btn-rounded" disabled>Class Ended</button>
															</div>
														@else
															<div class="card-detail">
																<a href="/subjects/view/dashboard/{{$row->class_id}}" class="btn btn-light btn-rounded">Enter Subject</a>
															</div>
														@endif
													@else
														<div class="card-detail">
															<a href="/subjects/view/dashboard/{{$row->class_id}}" class="btn btn-light btn-rounded">Enter Subject</a>
														</div>
													@endif
												</div>
											</div>
										</div>
                                    @endforeach
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
	<!-- Modal -->
	<form action="/driver_type/add" method="POST" id="myForm">
		@csrf
	    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
	        <div class="modal-dialog" role="document">									
	            <div class="modal-content">
	                <div class="modal-header bg-success">
	                    <h5 class="modal-title">
	                        <span class="fw-mediumbold">
	                        New</span> 
	                        <span class="fw-light">
	                            Class
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
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Class Name </label>
	                                <input type="hidden" name="id" id="id" class="form-control">
	                                <input type="text" name="class_name" id="class_name" class="form-control" placeholder="" required>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Section</label>
	                                <select name="id_section" id="id_section" class="form-control" required>
	                                    <option value="">Select</option>
	                                    @foreach($sections as $row)
	                                    <option value="<?= $row->id?>"><?= $row->category?></option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Room</label>
	                                <select name="id_room" id="id_room" class="form-control" required>
	                                    <option value="">Select</option>
	                                    @foreach($rooms as $row)
	                                    <option value="<?= $row->id?>"><?= $row->category?></option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Subject</label>
	                                <select name="id_subject" id="id_subject" class="form-control" required>
	                                    <option value="">Select</option>
	                                    @foreach($subjects as $row)
	                                    <option value="<?= $row->id?>"><?= $row->category?></option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Select Day</label>
	                                <select name="id_day" id="id_day" class="form-control" required>
	                                    <option value="">Select</option>
	                                    @foreach($days_management as $row)
	                                    <option value="<?= $row->id?>"><?= $row->category?></option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>
	                        <div class="col-md-6">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger">*</span> Select Time</label>
	                                <select name="id_time" id="id_time" class="form-control" required>
	                                    <option value="">Select</option>
	                                    @foreach($time_management as $row)
	                                    <option value="<?= $row->id?>"><?= $row->category?></option>
	                                    @endforeach
	                                </select>
	                            </div>
	                        </div>

	                        <div class="col-md-12">
	                            <div class="form-group form-group-default">
	                                <label><span class="text-danger"></span> Class Description </label>
	                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	                <div class="modal-footer no-bd">
	                    <button type="submit" id="btnssave" class="btn btn-success"><i class="fa fa-save"></i> Save</button>
	                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
	                </div>
	            </div>
	        </div>
	    </div>
	</form>
<script>
	$('#btnAdd').click(function(){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Create Class');
		$('#btnssave').text('Submit');
		$('#myForm').attr('action','/subjects/add');
		$("#id").val('');
        $('#class_name').val('');
        $('#description').val('');
        $('#id_section').val('').change;
        $('#id_room').val('').change;
        $('#id_subject').val('').change;
        $('#id_day').val('').change;
        $('#id_time').val('').change;
	});

	function getEdit(id){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Update Class');
		$('#myForm').attr('action','/subjects/update');
		$('#btnssave').text('Update');
		

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/class',
			data:{
				id:id
				},
			async: false,
			success: function(data){
				$("#id").val(data.id);
		        $('#class_name').val(data.class_name);
		        $('#description').val(data.description);
		        $('#id_section').val(data.id_section).change;
		        $('#id_room').val(data.id_room).change;
		        $('#id_subject').val(data.id_subject).change;
		        $('#id_day').val(data.id_day).change;
		        $('#id_time').val(data.id_time).change;
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	}

	$("#btnssave").click(function(e){
		e.preventDefault();

		let data = $("#myForm").serializeArray();
		for(var i=0;i<data.length;i++){
			if(data[i].name != 'id' && data[i].name != 'description'){
				if(data[i].value == ''){
					swal('Please fill-up all the required(*) fields','','warning');
					return false;
				}
			}
		}

		swal({
			title: "Update Subject Details?",
			text: "",
			icon: "warning",
			buttons: [
				'No!',
				'Yes!'
			],
			successMode: true,
		}).then(function(isConfirm) {
			if (isConfirm) {
				$("#myForm").submit();
			} else {
				return false;
			}
		})


	})
    function disableRecord(id, url){
        swal({
          title: "Disable Class?",
          text: "Disabling a class will prevent its Students from entering.",
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
              title: 'Class Disabled!',
              text: 'Class has been successfully disabled!',
              icon: 'success'
            }).then(function() {
                //RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
                location.reload();
            });
          }
        })
    }
    function enableRecord(id, url){
        swal({
          title: "Enable Class?",
          text: "Enabling a class will allow its Students from entering.",
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
              title: 'Class Enabled!',
              text: 'Class has been successfully enabled!',
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