@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/page') }}"><< Back to Pages</a></h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Add New Page
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Page Title : ') }}
                    {{ Form::text('title',$page->title,array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>
                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug',$page->slug,array('class'=>'form-control','id'=>'slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group">
                    {{ Form::label('Page Details : ') }}
                    {{ Form::textarea('details',$page->details,array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('details','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group">
                    {{ Form::label('Order')}}
                    {{ Form::selectRange('order', 1, 20,$page->order); }}
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
            url: "<?=url('admin/upload/index/blog')?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                //console.log(url);
                editor.insertImage(welEditable, url);
            }
        });
    }
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
</script>
@stop
