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
				            <li class="active">
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
						<h3>Learning Materials</h3>
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
					<div class="card-body">
						<div class="table-responsive">
							<table id="multi-filter-select" class="display table table-striped table-hover" >
								<thead>
									<tr>
										<th>Category</th>
										<th>Title</th>
										<th>Description</th>
										<th>Created By</th>
										@if($_SESSION['role']->id != 4)
											<th>Actions</th>
										@endif
									
									</tr>
								</thead>
								<tbody>
									@foreach($materials as $row)
										<tr>
											<td>{{$row->category}}</td>
											<td>
												@if($row->attached_file != '')
													<a download href="/uploads/learning-materials/{{$row->attached_file}}">{{$row->title}}</a>
												@else
													echo $row->title;
												@endif
												
											</td>
											<td>{{$row->description}}</td>
											<td>{{$row->last_name}}, {{$row->first_name}}</td>

											@if($_SESSION['role']->id == 1 || $_SESSION['role']->id == 3)
												@if($view_type != 'bin')
													<td>
														<div class="btn-group">
															<!-- <button title="View" class="btn btn-info btn-sm br-0" onclick="getEdit('{{$row->id }}')"><i class="fa fa-eye"></i></button> -->
															<!-- <button title="Copy" class="btn btn-info btn-sm br-0" onclick="createCopy('{{$row->id }}')"><i class="far fa-copy"></i></button> -->
															<button title="Edit" class="btn btn-warning btn-sm br-0" onclick="getEdit('{{$row->id }}')"><i class="fa fa-edit"></i></button>
															<button title="Delete" class="btn btn-danger btn-sm br-0" onclick="getDelete('{{$row ->id }}','/subjects/materials/delete')"><i class="fa fa-trash"></i></button>
														</div>
													</td>
												@else
													<td>
														<div class="btn-group">
															<a onclick="restorematerials('{{$row ->id }}','/subjects/materials/restore')" class="btn btn-info btn-sm br-0"><i class="fa fa-recycle"></i> Restore</a>
														</div>
													</td>
												@endif
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
<form action="/driver_type/add" method="POST" id="myForm" enctype="multipart/form-data">
	@csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">									
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        New</span> 
                        <span class="fw-light">
                            Learning Material
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
                                <label><span class="text-danger">*</span> LMS Category</label>
                            	<input type="hidden" name="id_class" id="id_class" value="{{$class->id}}">
                                <input  type="hidden" name="id" id="id" class="form-control">
                                <select name="id_category" id="id_category" class="form-control" required>
                                    <option value="">Select</option>
                                    @foreach($lms_categories as $row)
                                    <option value="<?= $row->id?>"><?= $row->category?></option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Title</label>
                                <input  type="text" name="title" id="title" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Upload a file</label>
                                <input  type="file" class="form-control" name="userfile" id="userfile" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span>  Description </label>
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
<script type="text/javascript">
	$('#btnAdd').click(function(){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Add Learning Material');
		$('#myForm').attr('action','/subjects/materials/add');
		$("#btnssave").attr('data-operation','save');
		$("#userfile").attr('required', true);
		$("#btnssave").text('Submit');
		$("#id").val('');
		$("#id_category").val('').change;
		$("#title").val('');
		$("#description").val('');
		$("#userfile").val('');
	});
	function getEdit(id){
		$('#addRowModal').modal('show');
		$('#addRowModal').find('.modal-title').text('Edit Assessment');
		$("#userfile").removeAttr('required');
		$('#myForm').attr('action','/subjects/materials/update');

		$.ajax({
			type: 'ajax',
			method: 'get',
			url: '/fetch/materials/'+id,
			data:{
				id:id,
				},
			async: false,
			success: function(data){
				$("#id").val(data.id);
				$("#id_category").val(data.id_category).change;
				$("#title").val(data.title);
				$("#description").val(data.description);
				$("#userfile").val('');
			},
			error: function(){
				swal('Something went wrong');
			}
		});
	}
	function getDelete(id,url){
		swal({
		  title: "Remove Learning Material?",
		  text: "Removing this learning material will remove this from the learning materials tab!",
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
			  title: 'Learning material has been successfully removed!',
			  text: '',
			  icon: 'success'
			}).then(function() {
				//RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
				location.reload();
			});
		  }
		})
	};
    function restorematerials(id, url){
        swal({
          title: "Restore Learning Material?",
          text: "Restoring this learning material will remove it from the archived section.",
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
              title: 'Learning material Restored!',
              text: 'Learning material has been successfully restored!',
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