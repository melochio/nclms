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
                                <h4 class="card-title">List of <?= ucwords($header_title)?></h4>
                                <button id="btnAdd" onclick="addRow()" class="btn btn-warning btn-round ml-auto">
                                    <i class="fa fa-plus"></i>
                                    Add
                                </button>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="table-responsive">
                                <table id="multi-filter-select" class="display table table-striped table-hover" >
                                    <thead>
                                        <tr>
                                            <th>Category / Type</th>
                                            <th>Description</th>
                                            <th>Option</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <?php foreach($categories as $row): ?>
                                            <tr>
                                                <td><?= $row->category?></td>
                                                <td><?= $row->description?></td>
                                                <td>
                                                    <div class="btn-group">
                                                        <button title="Edit" class="form-control btn-warning btn-sm br-0" style="cursor: pointer" onclick="getEdit('{{$row->id}}')" ><i class="fa fa-edit"></i></button>
                                                        @if($row->del_status == 1)
                                                        <button title="Disable" class="form-control btn-danger btn-sm br-0" style="cursor: pointer" onclick="disableRecord('{{$row->id}}','/categories/disablerecord')"><i class="fa fa-toggle-off"></i> Disable</button>
                                                        @else
                                                        <button title="Enable" class="form-control btn-success btn-sm br-0" style="cursor: pointer" onclick="enableRecord('{{$row->id}}','/categories/enablerecord')"><i class="fa fa-toggle-on"></i> Enable</button>
                                                        @endif
                                                    </div>
                                                </td>
                                            </tr>
                                        <?php endforeach; ?>
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
<form action="" method="POST" id="myForm">
    @csrf
    <div class="modal fade" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
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
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger">*</span> Input Category / Type </label>
                                @if($header_title == "Rooms")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="7">
                                @elseif($header_title == "Sections")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="6">
                                @elseif($header_title == "Subjects")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="8">
                                @elseif($header_title == "Learning Materials Category")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="9">
                                @elseif($header_title == "Time Category")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="10">
                                @elseif($header_title == "Days Category")
                                    <input  type="hidden" name="id_category_type" id="id_category_type" value="11">
                                @endif
                                <input  type="hidden" name="id" id="id" class="form-control">
                                <input  type="text" name="category" id="category" class="form-control" placeholder="" required>
                            </div>
                        </div>
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <label><span class="text-danger"></span> Description </label>
                                <textarea name="description" id="description" cols="30" rows="5" class="form-control"></textarea>
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
    function addRow(){
        $('#addRowModal').modal('show');
        $('#addRowModal').find('.modal-title').text('<?php echo $header_title; ?> Details');
        $('#myForm').attr('action','/categories/addcategory');

        $("#id").val('');
        $("#category").val('');
        $("#description").val('');
    };

    function getEdit(id){
        $('#addRowModal').modal('show');
        $('#addRowModal').find('.modal-title').text('Update');
        $('#myForm').attr('action','/categories/updatecategory');
        $('#btnssave').text('Update');
        $('#btnssave').attr('data-operation','update');
        

        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/fetch/category',
            data:{
                id:id
                },
            async: false,
            success: function(data){
                $("#id").val(data.id);
                $("#category").val(data.category);
                $("#description").val(data.description);
            },
            error: function(){
                swal('Something went wrong');
            }
        });
    }

    function disableRecord(id, url){
        swal({
          title: "Disable Record?",
          text: "Disabling a category record will prevent it from showing on all category list.",
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
              title: 'Category Disabled!',
              text: 'Category has been successfully disabled!',
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
          title: "Enable Record?",
          text: "Enabling a category record will allow it to be shown on all category list.",
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
              title: 'Category Enabled!',
              text: 'Category has been successfully enabled!',
              icon: 'success'
            }).then(function() {
                //RELOAD THE PAGE TO SHOW CHANGES AFTER DELETE
                location.reload();
            });
          }
        })
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