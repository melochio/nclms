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

		<!-- CSS Just for demo purpose, don't include it in your project -->
		<link rel="stylesheet" href="/assets/css/demo.css">
		<link rel="stylesheet" href="/assets/css/jrey.css">
	</head>
	<style>
		.box-shadow {
			box-shadow: 2px 6px 15px 0px rgb(69 65 78 / 10%) !important;
		}

		.logo-header {
		    background: #007E35!important;
		} 

		.navbar-header {
		    background: #ffc107ed!important;
		}

		.bg-primary-gradient {
		    background: #1572e8!important;
		    background: -webkit-linear-gradient(legacy-direction(-45deg),#06418e,#1572e8)!important;
		    background: linear-gradient( 
		-45deg
		 ,#007e35,#007e35)!important;
		}

		.bg-secondary {
		    background: #273051!important;
		}

		.c-theme-bg{
			background-color:#273051 !important;
		}

		.c-theme-text{
			color:#273051 !important;
		}


		.w-100{
			width: 100%;
		}


		.btn{
			color:#fff !important;
		}

		.sidebar.sidebar-style-2 .nav.nav-primary>.nav-item.active>a {
		    background: #31CE36!important;
		    box-shadow: 4px 4px 10px 0 rgba(0,0,0,.1),4px 4px 15px -5px rgba(21,114,232,.4)!important;
		}
	</style>
	<body data-background-color="bg2">
		<div>
			<div class="main-header">
				<!-- Logo Header -->
				<div class="logo-header">
					<a href="/user/" class="logo">
		                <h3 class="navbar-brand card-title mt-3" style="font-size: 18px;"><span class="text-white">My NC e-learning for NC </span></h3>
					</a>
					<button class="navbar-toggler sidenav-toggler ml-auto" type="button" data-toggle="collapse" data-target="collapse" aria-expanded="false" aria-label="Toggle navigation">
						<span class="navbar-toggler-icon">
							<i class="icon-menu"></i>
						</span>
					</button>
				</div> 
				<!-- End Logo Header -->

				<!-- Navbar Header -->
				<nav class="navbar navbar-header navbar-expand-lg">
					
					<div class="container-fluid">
						<div class="collapse" id="search-nav">
							<form class="navbar-left navbar-form nav-search mr-md-3">
								<!-- <div class="input-group">
									<div class="input-group-prepend">
										<button type="submit" class="btn btn-search pr-1">
											<i class="fa fa-search search-icon"></i>
										</button>
									</div>
									<input type="text" placeholder="Search ..." class="form-control">
								</div> -->
							</form>
							
							<h3 class="navbar-brand card-title mt-1" style="font-size: 18px;"><span  class="text-white"><?= ucfirst($_SESSION['role']->role) ?> Dashboard</span></h3>
						</div>
						<ul class="navbar-nav topbar-nav ml-md-auto align-items-center">
							<li class="nav-item toggle-nav-search hidden-caret">
								<a class="nav-link" data-toggle="collapse" href="#search-nav" role="button" aria-expanded="false" aria-controls="search-nav">
									<i class="fa fa-search"></i>
								</a>
							</li>
							<li class="nav-item dropdown hidden-caret">
								<a class="dropdown-toggle profile-pic" data-toggle="dropdown" href="#" aria-expanded="false">
									<div class="avatar-sm">
										<img src="/uploads/dp/<?php echo isset($_SESSION['user_profile']->picture) ? $_SESSION['user_profile']->picture  : 'default_pic.png' ?>" alt="..." class="avatar-img rounded-circle">
									</div>
								</a>
								<ul class="dropdown-menu dropdown-user animated fadeIn">
									<div class="scroll-wrapper dropdown-user-scroll scrollbar-outer" style="position: relative;"><div class="dropdown-user-scroll scrollbar-outer scroll-content" style="height: auto; margin-bottom: 0px; margin-right: 0px; max-height: 0px;">
										<li>
											<div class="user-box">
												<div class="avatar-lg"><img src="/uploads/dp/<?php echo isset($_SESSION['user_profile']->picture) ? $_SESSION['user_profile']->picture  : 'default_pic.png' ?>" alt="image profile" class="avatar-img rounded"></div>
												<div class="u-text">
													<h4><?= $_SESSION['user_profile']->last_name ?>, <?= $_SESSION['user_profile']->first_name ?>  </h4>
													<p class="text-muted"><?= ucfirst($_SESSION['role']->role) ?></p>
												</div>
											</div>
										</li>
										<li>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/profile">Account Setting</a>
											<div class="dropdown-divider"></div>
											<a class="dropdown-item" href="/logout">Logout</a>
										</li>
									</div><div class="scroll-element scroll-x" style=""><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle"></div></div></div><div class="scroll-element scroll-y" style=""><div class="scroll-element_outer"><div class="scroll-element_size"></div><div class="scroll-element_track"></div><div class="scroll-bar ui-draggable ui-draggable-handle"></div></div></div></div>
								</ul>
							</li>


			
						</ul>
					</div>
				</nav>
				<!-- End Navbar -->
			</div>


			<!-- Sidebar -->
			<div class="sidebar sidebar-style-2" data-background-color="white">
				<div class="sidebar-wrapper scrollbar scrollbar-inner">
					<div class="sidebar-content">
						<div class="user">
							<div class="avatar-sm float-left mr-2">
								<img src="/uploads/dp/<?php echo empty($_SESSION['user_profile']->picture) ? 'default_pic.png' : $_SESSION['user_profile']->picture ?>" alt="..." class="avatar-img rounded-circle">
							</div>
							<div class="info">
								<a data-toggle="collapse" href="#collapseExample" aria-expanded="true">
									<span>
										<?= $_SESSION['user_profile']->last_name?>, <?= $_SESSION['user_profile']->first_name?>
										<span class="user-level">
											<?php
											if($_SESSION['role']->id == 1){
												echo ucfirst($_SESSION['role']->role);
											}else{
												echo ucfirst($_SESSION['role']->role).': '.$_SESSION['user_profile']->account_id;
											}
											?>
										</span>
									</span>
								</a>
								<div class="clearfix"></div>
							</div>
						</div>
						<ul class="nav nav-primary">
							<li class="nav-section">
								<span class="sidebar-mini-icon">
									<i class="fa fa-ellipsis-h"></i>
								</span>
								<h4 class="text-section">Components</h4>
							</li>
							<li class="nav-item">
								<a href="/dashboard">
									<i class="fas fa-desktop"></i>
									<p>Dashboard</p>
								</a>
							</li>
							<li class="nav-item">
								<a href="/newsfeed">
									<i class="fas fa-rss"></i>
									<p>Public Feed</p>
								</a>
							</li>
							@if($_SESSION['role']->id == 3)
								<li class="nav-item">
									<a href="/subjects">
										<i class="fas fa-users"></i>
										<p>My Subjects</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="#" onclick="swal('Sorry but this feature is still unavailable')">
										<i class="fas fa-calculator"></i>
										<p>Grades Management</p>
									</a>
								</li>
							@endif
							
							@if($_SESSION['role']->id == 4)
								<li class="nav-item">
									<a href="#" onclick="swal('Sorry but this feature is still unavailable')">
										<i class="fas fa-list"></i>
										<p>Todo List</p>
									</a>
								</li>
								<li class="nav-item">
									<a href="/subjects">
										<i class="fas fa-chalkboard"></i>
										<p>My Subjects</p>
									</a>
								</li>
							@endif
							@if($_SESSION['role']->id == 1)
								<li class="nav-item">
									<a href="/usermanagement/students">
										<i class="fas fa-users"></i>
										<p>Students Management</p>
										
									</a>
								</li>
								<li class="nav-item">
									<a href="/usermanagement/teachers">
										<i class="fas fa-users"></i>
										<p>Teachers Management</p>
										
									</a>
								</li>
								<li class="nav-item">
									<a href="/subjects">
										<i class="fas fa-chalkboard"></i>
										<p>Subject List</p>
										
									</a>
								</li>
								<li class="nav-item">
									<a href="/roommanagement">
										<i class="fas fa-warehouse"></i>
										<p>Rooms Management</p>
										
									</a>
								</li>
								
								<li class="nav-item">
									<a href="/sectionmanagement">
										<i class="fas fa-list"></i>
										<p>Sections Management</p>
										
									</a>
								</li>
								<li class="nav-item">
									<a href="/subjectmanagement">
										<i class="fas fa-paperclip"></i>
										<p>Subjects Management</p>
										
									</a>
								</li>
								<li class="nav-item">
									<a data-toggle="collapse" href="#sidebarLayouts" class="collapsed" aria-expanded="false">
										<i class="fas fa-cogs"></i>
										<p>System Settings</p>
										<span class="caret"></span>
									</a>
									<div class="collapse" id="sidebarLayouts" style="">
										<ul class="nav nav-collapse">
											<li class="">
												<a href="/materialsmanagement">
													<span class="sub-item">Learning Materials <br> Category</span>
												</a>
											</li>
											<li class="">
												<a href="/timemanagement">
													<span class="sub-item">Time Management</span>
												</a>
											</li>
											<li class="">
												<a href="/daysmanagement">
													<span class="sub-item">Days management</span>
												</a>
											</li>
										</ul>
									</div>
								</li>
							@endif
						
							<li class="nav-item">
								<a href="/logout/">
									<i class="fas fa-sign-out-alt"></i>
									<p>Sign Out</p>
									
								</a>
							</li>
						</ul>
					</div>
				</div>
			</div>
	<!-- End Sidebar -->
	@yield('header')
	@yield('body')
	</body>

	<!--   Core JS Files   -->
	<script src="/assets/js/core/jquery.3.2.1.min.js"></script>
	<script src="/assets/js/core/popper.min.js"></script>
	<script src="/assets/js/core/bootstrap.min.js"></script>

	<!-- jQuery UI -->
	<script src="/assets/js/plugin/jquery-ui-1.12.1.custom/jquery-ui.min.js"></script>
	<script src="/assets/js/plugin/jquery-ui-touch-punch/jquery.ui.touch-punch.min.js"></script>

	<!-- jQuery Scrollbar -->
	<script src="/assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>


	<!-- Chart JS -->
	<script src="/assets/js/plugin/chart.js/chart.min.js"></script>

	<!-- jQuery Sparkline -->
	<script src="/assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>

	<!-- Chart Circle -->
	<script src="/assets/js/plugin/chart-circle/circles.min.js"></script>

	<!-- Datatables -->
	<script src="/assets/js/plugin/datatables/datatables.min.js"></script>

	<!-- Bootstrap Notify -->
	<script src="/assets/js/plugin/bootstrap-notify/bootstrap-notify.min.js"></script>

	<!-- jQuery Vector Maps -->
	<script src="/assets/js/plugin/jqvmap/jquery.vmap.min.js"></script>
	<script src="/assets/js/plugin/jqvmap/maps/jquery.vmap.world.js"></script>

	<!-- Sweet Alert -->
	<script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>

	<!-- Atlantis JS -->
	<script src="/assets/js/atlantis.min.js"></script>

	<!-- Atlantis DEMO methods, don't include it in your project! -->
	<script src="/assets/js/setting-demo.js"></script>

	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.10/js/select2.min.js"></script>

    <script >
		$(document).ready(function() {
			$('#basic-datatables').DataTable({
			});

			$('#multi-filter-select').DataTable( {
				"pageLength": 5,
				initComplete: function () {
					this.api().columns().every( function () {
						var column = this;
						var select = $('<select class="form-control"><option value=""></option></select>')
						.appendTo( $(column.footer()).empty() )
						.on( 'change', function () {
							var val = $.fn.dataTable.util.escapeRegex(
								$(this).val()
								);

							column
							.search( val ? '^'+val+'$' : '', true, false )
							.draw();
						} );

						column.data().unique().sort().each( function ( d, j ) {
							select.append( '<option value="'+d+'">'+d+'</option>' )
						} );
					} );
				}
			});

			// Add Row
			$('#add-row').DataTable({
				"pageLength": 5,
			});

			var action = '<td> <div class="form-button-action"> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-primary btn-lg" data-original-title="Edit Task"> <i class="fa fa-edit"></i> </button> <button type="button" data-toggle="tooltip" title="" class="btn btn-link btn-danger" data-original-title="Remove"> <i class="fa fa-times"></i> </button> </div> </td>';

			$('#addRowButton').click(function() {
				$('#add-row').dataTable().fnAddData([
					$("#addName").val(),
					$("#addPosition").val(),
					$("#addOffice").val(),
					action
					]);
				$('#addRowModal').modal('hide');

			});
		});
		Circles.create({
			id:'circles-1',
			radius:45,
			value:60,
			maxValue:100,
			width:7,
			text: 5,
			colors:['#f1f1f1', '#FF9E27'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-2',
			radius:45,
			value:70,
			maxValue:100,
			width:7,
			text: 36,
			colors:['#f1f1f1', '#2BB930'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})

		Circles.create({
			id:'circles-3',
			radius:45,
			value:40,
			maxValue:100,
			width:7,
			text: 12,
			colors:['#f1f1f1', '#F25961'],
			duration:400,
			wrpClass:'circles-wrp',
			textClass:'circles-text',
			styleWrapper:true,
			styleText:true
		})
		function sidepanel_active(a){
			$('a').removeClass('active');
			localStorage['active'] = $(this).attr('href');
		}
		$(document).ready(function(){
			if(localStorage['active'] == null){
				var side = "/dashboard";
				localStorage['active'] = side;
			}
			else{
				var side = localStorage['active'];
			}
			$('a[href="'+side+'"]').parent().addClass('active');
		})
	</script>
    <script src="/assets/js/plugin/sweetalert/sweetalert.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.css">
	@yield('footer')
</html>