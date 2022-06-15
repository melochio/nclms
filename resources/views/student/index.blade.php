@extends('layout.master')
@section('header')
@stop
@section('sidepanel')
@stop
@section('body')
	<div class="main-panel">
		<div class="content" style="background-color: #d3d3d3a1;">
			<div class="page-inner">
				<div class="row mt--2">
					<div class="col-xs-12 col-md-12">
						<div class="card full-height">
							<div class="card-body">
								<div class="card-title">Overall statistics</div>
								<div class="d-flex flex-wrap justify-content-around pt-4">
									<div class="col-xs-12 col-md-4">
										<a href="/usermanagement/students" style="text-decoration: none">
											<div class="card card-stats card-round" style="cursor: pointer">
												<div class="card-body">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fas fa-users text-success"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Students</p>
																<h4 class="card-title">{{ $report['students_count'] }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
									<div class="col-xs-12 col-md-4">
										<a href="/usermanagement/teachers" style="text-decoration: none">
											<div class="card card-stats card-round" style="cursor: pointer">
												<div class="card-body">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fas fa-users text-success"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Teachers</p>
																<h4 class="card-title">{{ $report['teachers_count'] }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
									<div class="col-xs-12 col-md-4">
										<a href="/subjects" style="text-decoration: none">
											<div class="card card-stats  card-round" style="cursor: pointer">
												<div class="card-body ">
													<div class="row">
														<div class="col-5">
															<div class="icon-big text-center">
																<i class="fas fas fa-archway text-success"></i>
															</div>
														</div>
														<div class="col-7 col-stats">
															<div class="numbers">
																<p class="card-category">Active Classes</p>
																<h4 class="card-title">{{ $report['classes_count'] }}</h4>
															</div>
														</div>
													</div>
												</div>
											</div>
										</a>
									</div>
								</div>
							</div>
						</div>
					</div>
					@if(\Auth::user()->id_user_role > 1)
					<div class="col-md-12" style="max-height: 400px;">
						<div class="card" style="max-height: 90%">
							<div class="card-header">
								<div class="card-head-row">
									<h4 class="card-title">Invitations</h4>
								</div>
							</div>
							<div class="card-body" style="overflow-y: auto;">
								
								@if(count($class_invitation) < 1)
									<div class="row">
										<div class="col-md-12 text-center">
											<h4 style="color: gray"><b>No Invitations Found</b></h4>
											<h5 style="color: lightgray"><b>(Please contact/coordinate with the school admin to get a class invitation)</b></h5>
										</div>
									</div>
								@else
									@foreach($class_invitation as $row)
										<div class="row">
											<div class="col-md-12">
												<div class="alert alert-success">
													<h4>You received an invitation to join in class: <b>{{ $row->class_name }}</b></h4> 
													<div class="btn-group "> 
														<button class="btn btn-info btn-sm">Accept</button>
														<button class="btn btn-danger btn-sm">Cancel</button>
													</div>
												</div>
											</div>
										</div>
									@endforeach
								@endif
							</div>
						</div>
					</div>
					@endif
				</div>
			</div>
		</div>
	</div>
@endsection
@section('footer')
@endsection