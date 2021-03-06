@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="resource">
<div class="row">
    <div class="col-lg-12">
        <!--        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create_category/') }}">Add New Category</a>-->
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/press') }}">Press List</a>
    </div>

</div>

<div class="row"><h1/></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Update Press
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title',$press->title,array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>
                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug',$press->slug,array('class'=>'form-control','id'=>'slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content',$press->content,array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status', $press->status, $press->status) }}
                </div>
                <div class="form-group">
                    {{ Form::label('image_upload_status','Do You Want To Upload Images? : ') }}
                    {{ Form::checkbox('image_upload_status','',false,array('id'=>'image_upload_status')) }}
                    {{ $errors->first('image_upload_status','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group  file-control">
                    @if($press->image_link_1)
                    <div class="col-lg-2 ">
                        <img style="border-radius: 5px;" src={{$press->image_link_1 }} height="100" width="100">
                    </div>
                    <div class="col-lg-5 ">
                        {{ Form::label('Images : ') }}

                        {{ Form::file('image_file[0]') }}
                    </div>

                    <div class="clearfix"></div>
                    @endif
                    @if($press->image_link_2)
                    <div class="col-lg-2 ">
                        <img style="border-radius: 5px;" src={{$press->image_link_2 }} height="100" width="100">
                    </div>
                    <div class="col-lg-5 ">
                        {{ Form::label('Images : ') }}

                        {{ Form::file('image_file[1]') }}
                    </div>

                    <div class="clearfix"></div>
                    @endif
                    @if($press->image_link_3)
                    <div class="col-lg-2 ">
                        <img style="border-radius: 5px;" src={{$press->image_link_3 }} height="100" width="100">
                    </div>
                    <div class="col-lg-5 ">
                        {{ Form::label('Images : ') }}

                        {{ Form::file('image_file[2]') }}
                    </div>

                    <div class="clearfix"></div>
                    @endif
                    @if($press->image_link_4)
                    <div class="col-lg-2 ">
                        <img style="border-radius: 5px;" src={{$press->image_link_4 }} height="100" width="100">
                    </div>
                    <div class="col-lg-5 ">
                        {{ Form::label('Images : ') }}

                        {{ Form::file('image_file[3]') }}
                    </div>

                    <div class="clearfix"></div>
                    @endif
                    @if(!$press->image_link_2 || !$press->image_link_3 || !$press->image_link_4)
                    <a class='add_more' href=''>Add More</a>
                    @endif
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Save',array('class'=>'btn btn-primary')); }}

                </div>

                {{ Form::close() }}

            </div>
        </div>

    </div>
    <!-- /.row (nested) -->
</div>
<!-- /.panel-body -->
</div>
<!-- /.panel -->

<script type="text/javascript">
    var slug = function(str) {
        var $slug = '';
        var trimmed = $.trim(str);
        $slug = trimmed.replace(/[^a-z0-9-]/gi, '-').
            replace(/-+/g, '-').
            replace(/^-|-$/g, '');
        return $slug.toLowerCase();
    }

    $('#image_upload_status').click(function()
    {
        if($(this).is(':checked'))
            $('.file-control').removeClass('hide');
        else
            $('.file-control').addClass('hide');
    });
    var  count=0;
    $('#form').on('click','.add_more',function(event)
    {
        event.preventDefault();
        if(count>=3){
            var htmlImage = '<input class="file" type="file" name="image_file[]">';
            $(this).after(htmlImage);
            $(this).remove();
        }else{
            var htmlImage = '<input class="file" type="file" name="image_file[]"><a class="add_more" href="">Add More</a>';
            $(this).after(htmlImage);
            $(this).remove();
        }
        count++;
    });
    $("#title").keyup(function()
    {
        var slug1= slug($('#title').val());
        $("#slug").val(slug1);
    });
    $('#summernote').summernote({
        height: 250,
        onImageUpload: function(files, editor, welEditable) {
            sendFile(files[0],editor,welEditable);
            console.log(files);
            console.log(editor);
            console.log( welEditable);
        }
    });
    function sendFile(file,editor,welEditable) {
        data = new FormData();
        data.append("file", file);
        $.ajax({
            data: data,
            type: "POST",
            url: "<?=url('admin/upload/index/press')?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                //console.log(url);
                editor.insertImage(welEditable, url);
            }
        });
    }
</script>
@stop
