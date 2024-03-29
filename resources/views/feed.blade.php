@extends('layout.master')
@section('header')
@endsection
@section('sidepanel')
@endsection
@section('body')
<div class="main-panel">
    <div class="content">
        <div class="page-inner">
            <div class="row row-card-no-pd">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="card-head-row">
                                <h4 class="card-title">Public Feed</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            @if($_SESSION['role']->id != 4)
                            <form action="/newsfeed/post" method="post" enctype="multipart/form-data" id="frmcreatepost">
                                @csrf
                            	<div class="col-md-8 col-sm-12" style="border: lightgray 1px solid; border-radius: 0.5em; padding: 2em 2em 0em 2em">
                            		<h4><b>Create Post</b></h4>
                            		<div class="col-md-12 mb-3">
                            			<textarea class="form-control" name="description" id="descriptionInput" placeholder="Write something here"></textarea>
                            		</div>
                            		<div class="col-md-12 row" style="padding-right: 0px">
                                        <input type="file" style="display: none" id="attached_fileInput_img" name="attached_fileInput_img" accept="image/png, image/jpeg, image/jpg">
                                        <div class="col-md-12" style="display: none">
                                            <button class="btn btn-sm" id="remove_fileimg" style="border-radius: 50%;position: absolute;left: 92%;top: 2%;background-color: red;font-weight: bold;">x</button>
                                            <img src="" id="attached_file_img" style="width: 100%;">
                                        </div>
                                        <div class="col-md-12" style="display: none">
                                            <input type="file" style="display: none" id="attached_fileInput_file" name="attached_fileInput_file">
                                            Attachment: <a href="#" id="attached_file_file"></a>
                                        </div>
                                        <div class="col-md-12" style="display: none">
                                            <input type="file" style="display: none" id="attached_fileInput_video" name="attached_fileInput_video" accept="video/*">
                                            <video width="400" controls id="attached_file_video">
                                              <source src="mov_bbb.mp4" id="video_display">
                                                Your browser does not support HTML5 video.
                                            </video>
                                        </div>
                            			<div class="col-md-10">
    	                        			<i onclick="attachfile('img')" style="margin: 1em; cursor: pointer; color: dodgerblue;" class="fa fa-image"></i>
    	                        			<i onclick="attachfile('file')" style="margin: 1em; cursor: pointer; color: coral; transform: rotate(315deg);" class="fa fa-paperclip"></i>
    	                        			<i onclick="attachfile('video')" style="margin: 1em; cursor: pointer; color: lightgreen;" class="fa fa-video"></i>
    	                        			<!-- <i onclick="attachfile('poll')" style="margin: 1em; cursor: pointer; color: blue" class="fas fa-list"></i> -->
                            			</div>
                            			<div class="col-md-2">
    	                        			<button class="btn btn-primary btn-round mb-4" type="button" onclick="postfeed()" style="float:right">Post</button>
                            			</div>
                            		</div>
                            	</div>
                            </form>
                            @endif
                            @foreach($feed as $val)
                            	<div class="col-md-8 col-sm-12 mt-3" style="border: lightgray 1px solid; border-radius: 0.5em; padding: 2em 0em 0em 0em">
                            		<div class="col-md-12 mb-3 row ml-2">
                            			<div class="col-md-1">
                            				<img src="/uploads/dp/{{$val->picture}}" style="width: 100%; border-radius: 50%;">
                            			</div>
                            			<div class="col-md-10">
                                            @if($val->id_user == $_SESSION['user_profile']->id)
                                            <div class="dropleft">
                                                <i class="fa fa-ellipsis-v" data-toggle="dropdown" style="color: gray; position: absolute; left: 105%; cursor: pointer;"></i>
                                                <div class="dropdown-menu">
                                                  <!-- <a style="color: dodgerblue;" class="dropdown-item" href="#" onclick="getEdit({{$val->id}})"><i class="fa fa-edit"></i> Edit</a> -->
                                                  <a style="color: #f75a5a;" class="dropdown-item" href="#" onclick="getDelete({{$val->id}})"><i class="fa fa-trash"></i> Delete</a>
                                                </div>
                                            </div>
                                            @endif
                            				<h5><b>{{$val->last_name}}, {{$val->first_name}} {{$val->middle_name}}</b></h5>
                            				<h6 style="color: darkgray">{{date('M j, Y - g:i a', strtotime($val->created_at))}}</h6>
                            			</div>
                            		</div>
                            		<div class="col-md-12 ml-3">
                            			<p>{{$val->description}}</p>
                            		</div>
                                    @if($val->attached_file != "" || $val->attached_file != null)
                            		<div class="col-md-12 attachments">
                            			<div class="col-md-12">
    	                        			<h6 style="color:lightgray">Attachment</h6><hr>
                            			</div>
                            			<div class="col-md-12 row mb-3">
                            				<div class="col-md-10">
                                                @if(preg_match('/^.*\.(ogm|wmv|mpg|webm|ogv|mov|asx|mpeg|mp4|m4v|avi)$/i', $val->attached_file))
                                                    <video width="400" controls>
                                                      <source src="/uploads/feed/public/{{$val->attached_file}}">
                                                        Your browser does not support HTML5 video.
                                                    </video>
                                                @elseif(preg_match('/^.*\.(png|pjp|jpg|pjpeg|jpeg|jfif)$/i', $val->attached_file))
                                                    <img src="/uploads/feed/public/{{$val->attached_file}}" style="width:100%">
                                                @else
        	                        				<h5>{{$val->attached_file}}</h5>
                                                @endif
                            				</div>
                            				<div class="col-md-2 text-right">
                            					<a href="/uploads/feed/public/{{$val->attached_file}}" download><i class="fas fa-download"></i></a>
                            				</div>
                            			</div>
                            		</div>
                                    @endif
    							    <div class="card-footer">
                                        @if(\DB::table('feed_comments')->where('id_feed', $val->id)->count() > 0)
                                            <i class="fa fa-comment"></i>&nbsp;&nbsp; <a href="#" onclick="comment({{$val->id}})" style="color: gray">View {{\DB::table('feed_comments')->where('id_feed', $val->id)->count()}} Comments</a>
                                        @else
        								    <i class="fa fa-comment"></i>&nbsp;&nbsp; <a href="#" onclick="comment({{$val->id}})" style="color: gray">Write a comment</a>
                                        @endif
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

<!-- Modal -->
    <div class="modal" data-keyboard="false" data-backdrop="static" id="addRowModal" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">                                  
            <div class="modal-content">
                <div class="modal-header bg-success">
                    <h5 class="modal-title">
                        <span class="fw-mediumbold">
                            Post Comments
                        </span> 
                    </h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">          
                    <div class="row col-md-12">
                        <div class="col-md-12 row p-3" id="commentlist">                   
                        </div>  
                        <div class="col-md-12">
                            <div class="form-group form-group-default">
                                <div class="input-group">
                                    <input type="text" class="form-control" name="commentInput" id="commentInput" 
                                    placeholder="Enter comment here" aria-label="" aria-describedby="basic-addon1">
                                    <div class="input-group-prepend">
                                        <button class="btn btn-primary" style="border-radius: 50%; padding: 10px" id="btn_postcomment" type="button"><i class="fa fa-paper-plane"></i></button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@if($_SESSION['role']->id != 4)
<script type="text/javascript">
    function imagePreview(fileInput) {
        var f = document.getElementById("attached_fileInput_img").files[0];
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
                    $('#attached_file_img').attr('src', event.target.result);
                };
                fileReader.readAsDataURL(fileInput.files[0]);
            }
        }
    }
    function filepreview(){
        // $('#attached_file_file').attr('href', $('#attached_fileInput_file').files[0].mozFullPath);
        $('#attached_file_file').text($('#attached_fileInput_file').val().replace(/C:\\fakepath\\/i, ''));
        $('#attached_file_file').parent().css('display', '');

        $('#attached_file_img').parent().css('display', 'none');
        $('#attached_fileInput_img').val('');
        $('#attached_file_img').attr('src', '');

        $('#attached_fileInput_video').parent().css('display', 'none');
        $('#attached_fileInput_video').val('');
        $('#video_display').attr('src', 'mov_bbb.mp4');
    }
    $('#attached_fileInput_img').change(function(){
        imagePreview(this);

        $('#attached_file_file').parent().css('display', 'none');
        $('#attached_fileInput_file').val('');
        $('#attached_file_file').text('');

        $('#attached_file_img').parent().css('display', '');

        $('#attached_fileInput_video').parent().css('display', 'none');
        $('#attached_fileInput_video').val('');
        $('#video_display').attr('src', 'mov_bbb.mp4');
    })
    $('#attached_fileInput_file').change(function(){
        filepreview(this);
    })
    $(document).on("change", "#attached_fileInput_video", function(evt) {
      var $source = $('#video_display');
      $source[0].src = URL.createObjectURL(this.files[0]);
      $source.parent()[0].load();
        $('#attached_file_file').parent().css('display', 'none');
        $('#attached_file_img').parent().css('display', 'none');
        $('#attached_fileInput_video').parent().css('display', '');

        $('#attached_file_file').parent().css('display', 'none');
        $('#attached_fileInput_file').val('');
        $('#attached_file_file').text('');

        $('#attached_file_img').parent().css('display', 'none');
        $('#attached_fileInput_img').val('');
        $('#attached_file_img').attr('src', '');

        $('#attached_fileInput_video').parent().css('display', '');
    });
    function attachfile(type){
        if(type == "img"){
            $('#attached_fileInput_img').click();
        }
        else if(type == "file"){
            $('#attached_fileInput_file').click();
        }
        else if(type == "video"){
            $('#attached_fileInput_video').click();
        }
    }
    $('#remove_fileimg').click(function(){
        $('#attached_fileInput_img').val('');
        $('#attached_file_img').attr('src', '');
        $('#attached_file_img').parent().css('display', 'none');
    })
    function postfeed(){
        if($('#descriptionInput').val() != ""){
            swal({
              title: "Post this into the public feed?",
              text: "All Teachers and Students will be able to see this post.",
              icon: "warning",
              buttons: [
                'No',
                'Yes'
              ],
              dangerMode: true,
            }).then(function(isConfirm) {
              if (isConfirm) {
                $('#frmcreatepost').submit();
              }
            })
        }
        else{
            toastr.warning('Write something on the description field')
        }
    }
    function getEdit(id){
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/fetch/feed',
            data: {
                id: id
            },
            async: false,
            success: function(data){
            },
            error: function(){
                swal('Could not edit data');
            }
        });
    }
    function getDelete(id){
        swal({
          title: "Delete Post?",
          text: "Deleting a post will remove it from the public feed permanently.",
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
                url: '/newsfeed/delete',
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
              title: 'Post successfully deleted!',
              text: '',
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
    function comment(id){
        $('#addRowModal').modal('show');
        $('#btn_postcomment').attr('onclick', 'postcomment('+id+')');
        $.ajax({
            type: 'ajax',
            method: 'get',
            url: '/fetch/feedcomments',
            data: {
                id: id
            },
            async: false,
            success: function(data){
                $('#commentlist').empty();
                if(data.length > 0){
                    $.each(data, function(k, v){
                        $('#commentlist').append('<div class="col-md-12 row">'+
                            '<div class="col-md-2">'+
                                '<img src="/uploads/dp/'+v.picture+'" style="width: 60%; border-radius: 50%">'+
                            '</div>'+
                            '<div class="col-md-10">'+
                                '<div class="well">'+
                                    '<b>'+v.last_name+', '+v.first_name+' '+v.middle_name+'</b>'+
                                    '<p style="color:darkgray">'+v.created_at+'</p>'+
                                    '<p>'+v.description+'</p>'+
                                '</div>'+
                            '</div>'+
                        '</div>');
                    })
                }
                else{

                    $('#commentlist').append('<div class="col-md-12 row">'+
                        '<div class="col-md-12 text-center">'+
                            '<b style="color: darkgray">No Available Comments Yet</b>'+
                        '</div>'+
                    '</div>');
                }
            },
            error: function(){
                swal('Could not edit data');
            }
        });
    }
    function postcomment(id){
        var id = id;
        $.ajax({
            type: 'ajax',
            method: 'post',
            url: '/newsfeed/postcomment',
            data: {
                "_token": "{{ csrf_token() }}",
                id: id,
                description: $('#commentInput').val()
            },
            async: false,
            success: function(data){
                $.ajax({
                    type: 'ajax',
                    method: 'get',
                    url: '/fetch/feedcomments',
                    data: {
                        id: data
                    },
                    async: false,
                    success: function(a){
                        $('#commentlist').empty();
                        if(a.length > 0){
                            $.each(a, function(k, v){
                                $('#commentlist').append('<div class="col-md-12 row">'+
                                    '<div class="col-md-2">'+
                                        '<img src="/uploads/dp/'+v.picture+'" style="width: 60%; border-radius: 50%">'+
                                    '</div>'+
                                    '<div class="col-md-10">'+
                                        '<div class="well">'+
                                            '<b>'+v.last_name+', '+v.first_name+' '+v.middle_name+'</b>'+
                                            '<p style="color:darkgray">'+v.created_at+'</p>'+
                                            '<p>'+v.description+'</p>'+
                                        '</div>'+
                                    '</div>'+
                                '</div>');
                            })
                        }
                        else{

                            $('#commentlist').append('<div class="col-md-12 row">'+
                                '<div class="col-md-12 text-center">'+
                                    '<b style="color: darkgray">No Available Comments Yet</b>'+
                                '</div>'+
                            '</div>');
                        }
                    },
                    error: function(){
                        swal('Could not edit data');
                    }
                });
            },
            error: function(){
                swal('Could not edit data');
            }
        });
    }
</script>
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