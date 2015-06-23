@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/social_media') }}"><< Back to Social Media List</a></h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Update Social Media
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title',$social_media->title,array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group" >
                    {{ Form::label('Link : ') }}
                    {{ Form::text('link',$social_media->link,array('class'=>'form-control','id'=>'link')) }}
                    {{ $errors->first('link','<p class="text-red">:message</p>'); }}
                </div>

                <div class="form-group file-control row">
                    @if($social_media->image_link_1 != null)
                    <div class="col-lg-2 ">
                        <img style="border-radius: 5px;" src={{$social_media->image_link_1 }} height="100" width="100">
                    </div>
                    @endif
                    <div class="col-lg-5">
                    {{ Form::label('Main Icon : ') }}
                    {{ Form::file('image_file[]'); }}
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
                     </div>

                </div>
                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status', $social_media->status, $social_media->status) }}
                </div>
                <!--<div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content',$social_media->content,array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>-->


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
            url: "<?=url('admin/upload/index/guide')?>",
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
