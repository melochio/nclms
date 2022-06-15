@extends('layout.master')
@section('header')
@stop
@section('sidepanel')
@stop
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
                                <h4 class="card-title">List of Teachers</h4>
                                <div class="btn-group ml-auto">
                                    <button id="btnAdd" onclick="newUser()" class="btn btn-warning">
                                        <i class="fa fa-plus"></i>
                                        Add Teacher
                                    </button>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Gender</th>
                                            <th>Email</th>
                                            <th>Contact</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php
                                        foreach($users as $info){
                                        ?>
                                        <tr>
                                            <td>{{$info->last_name }},{{$info->first_name }}
                                            {{$info->middle_name }}</td>
                                            <td>{{$info->gender }}</td>
                                            <td>{{$info->email }}</td>
                                            <td>{{$info->contact }}</td>
                                            <td>
                                                <div class="btn-group">
                                                    <button title="Edit" class="btn btn-warning btn-sm br-0" onclick="getEdit('{{$info->id }}')"><i class="fa fa-edit"></i></button>
                                                    <button title="Archive" class="btn btn-danger btn-sm br-0" onclick="getArchive('{{$info ->id }}','/user/delete')"><i class="fa fa-archive"></i> Archive</button>
                                                </div>
                                            </td>
                                        </tr>
                                        <?php
                                        }
                                        ?>
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<form action="" method="POST" id="myForm" enctype="multipart/form-data">
    @csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">                                 
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                        New</span> 
                        <span class="fw-light">
                            Teacher
                        </span>
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">          
                    <div class="row p-3" id="data_for_edit">
                        <div class="col-md-12" id="error_msg">
                        </div>                       
                        <div class="row ">
                            <div class="col-md-3">
                                <div id="dp_uploaded">
                                    <img src="/uploads/dp/default_pic.png" class="img-thumbnail w-100 profilepic" id="img_preview" alt="">
                                </div>
                                <button type="button" class="btn btn-success btn-sm btn-block"  style="display:block;height:30px;" onclick="document.getElementById('upload_dp').click()">Upload Pic</button>
                                <input type='file' id="upload_dp" name="dp_picture" onchange="imagePreview(this)" style="display:none">
                            </div>
                            <div class="col-md-9">
                                <div class="row">
                                    <input type="hidden" name="id" id="id">
                                    <div class="col-md-12 mb-3 logindetails">
                                        <span class="bg-success bg-success btn-block text-white">Basic Details</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"><span class="text-danger">*</span></span> Last name</label>
                                            <input  type="text" name="last_name" id="last_name" class="form-control" placeholder="Last name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> First name</label>
                                            <input  type="text" name="first_name" id="first_name" class="form-control" placeholder="First name" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> MI</label>
                                            <input  type="text" name="middle_name" id="middle_name"class="form-control" placeholder="Mi" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"><span class="text-danger">*</span></span> Birthday</label>
                                            <input  type="date" name="birthday" id="birthday"class="form-control" placeholder="" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"></span> Gender</label>
                                            <select name="gender" id="gender" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="Male">Male</option>
                                                <option value="Female">Female</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"></span> Nationality</label>
                                            <input  type="text" name="nationality" id="nationality" class="form-control" placeholder="Nationality" value="Filipino" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"><span class="text-danger"></span></span> Civil Status</label>
                                            <select name="civil_status" id="civil_status" class="form-control" required>
                                                <option value="">Select</option>
                                                <option value="Single">Single</option>
                                                <option value="Married">Married</option>
                                                <option value="Divorce">Divorce</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"></span> Religion</label>
                                            <input  type="text" name="religion" id="religion" class="form-control" placeholder="Religion" required>
                                        </div>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> Contact</label>
                                            <input  type="text" name="contact" id="contact" class="form-control" placeholder="contact" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> Email</label>
                                            <input  type="text" name="email" id="email" class="form-control" placeholder="email" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> Address</label>
                                            <input  type="text" name="address" id="address" class="form-control" placeholder="address" required>
                                        </div>
                                    </div>
                                    <div class="col-md-12 mb-3 logindetails">
                                        <span class="bg-success bg-success btn-block text-white">Teacher Details</span>
                                    </div>
                                    <div class="col-md-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger"><span class="text-danger">*</span></span> Teacher ID # </label>
                                            <input  type="text" name="account_id" id="account_id" class="form-control" required>
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group form-group-default">
                                            <label><span class="text-danger">*</span> Upload Teacher ID</label>
                                            <input  type="file" name="id_picture" id="userfile" class="form-control" required>
                                        </div>
                                    </div>
                                    <div id="logincredentialField" style="padding-right: 0;" class="col-sm-12 row">
                                        <div class="col-md-12 mb-3 logindetails" style="padding-right: 0">
                                            <span class="bg-success bg-success btn-block text-white">Login Credentials</span>
                                        </div>
                                        <div class="col-md-6 logindetails" style="padding-right: 0">
                                            <div class="form-group form-group-default">
                                                <label><span class="text-danger">*</span> Username</label>
                                                <input  type="text" name="username" id="username" class="form-control" placeholder="Username" required>
                                            </div>
                                        </div>
                                        <div class="col-md-6 logindetails" style="padding-right: 0">
                                            <div class="form-group form-group-default">
                                                <label><span class="text-danger">*</span> Password</label>
                                                <input  type="password" name="password" id="password" class="form-control" placeholder="Password" required>
                                            </div>
                                        </div>
                                    </div>
                                </div>
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
    function imagePreview(fileInput) {
        var f = document.getElementById("upload_dp").files[0];
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
    function newUser(){
        $('#addRowModal').modal('show');
        $('#addRowModal').find('.modal-title').text('Teacher Details');
        $('#myForm').attr('action','/usermanagement/teachers');
        $("#first_name").val('');
        $("#middle_name").val('');
        $("#last_name").val('');
        $("#birthday").val('Single').change;
        $("#gender").val('Male').change;
        $("#nationality").val('');
        $("#civil_status").val('');
        $("#religion").val('');
        $("#email").val('');
        $("#contact").val('');
        $("#address").val('');
        $("#username").val('');
        $("#password").val('');
        $("#userfile").val('');
        $("#account_id").val('');
        $("#img_preview").attr('src', "/uploads/dp/default_pic.png");
        $('#userfile').attr('required', true);
        $("#username").attr('required',false);
        $("#password").attr('required',false);
        $('#logincredentialField').css('display', '');
    };
    function getEdit(id){
        $('#addRowModal').modal('show');
        $('#addRowModal').find('.modal-title').text('Update User');
        $('#myForm').attr('action','/usermanagement/user/update');
        $('#btnSaveProduct').text('Update');
        $("#username").attr('required',false);
        $("#password").attr('required',false);
        $('#logincredentialField').css('display', 'none');

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/fetch/userprofile',
            data:{
                id:id,
                },
            async: false,
            success: function(data){
                $('#id').val(data.id)
                $("#first_name").val(data.first_name);
                $("#middle_name").val(data.middle_name);
                $("#last_name").val(data.last_name);
                $("#birthday").val(data.birthday);
                $("#gender").val(data.gender);
                $("#nationality").val(data.nationality);
                $("#civil_status").val(data.civil_status);
                $("#religion").val(data.religion);
                $("#email").val(data.email);
                $("#contact").val(data.contact);
                $("#address").val(data.address);
                $("#account_id").val(data.account_id);
                $("#img_preview").attr({ "src": '/uploads/dp/' + data.picture });
                $('#userfile').removeAttr('required');
            },
            error: function(){
                swal('Something went wrong');
            }
        });
    }
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