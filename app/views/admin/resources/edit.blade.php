@extends('admin.layouts.default')

@section('content')
{{ HTML::script('assets/js/resource/category-manage.js') }}

<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="resource">
<div class="row">
    <div class="col-lg-12">
<!--        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create_category/') }}">Add New Category</a>-->
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource') }}">Resource List</a>
    </div>

</div>

<div class="row"><h1/></div>

<div class="modal fade" id="categoryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title" id="myModalLabel">Manage category</h4>
            </div>
            <div class="modal-body category-edit">

            </div>

            <div class="modal-body category-create">

            </div>

            <div class="modal-body category-list">

            </div>

        </div>
    </div>
</div>


<div class="panel panel-default">
    <div class="panel-heading">
        Edit Resource
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">
                {{ Form::open(array('role'=>"form",'files'=>true)) }}

                <div class="form-group">
                    {{ Form::label('Select a category:', 'Select a category');}}
                    {{ Form::select('category_id', array('' => 'Select One') + $categories, $resource->category_id,array('class'=>'ddlCategory')) }}
                    <a href="{{url('/admin/category')}}" class="btn btn-primary btn-lg manage-category" >
                        Manage category
                    </a>
                </div>

                <div class="form-group" >
                    {{ Form::label('Resource Title : ') }}
                    {{ Form::text('title',$resource->title,array('class'=>'form-control resource_title')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>
                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug',$resource->slug,array('class'=>'form-control slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status', $resource->status, $resource->status) }}
                </div>

                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content',$resource->content,array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>

                <div class="form-group">
                    {{ Form::submit('Update',array('class'=>'btn btn-primary')); }}
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
            url: "<?=url('admin/upload/index/resource')?>",
            cache: false,
            contentType: false,
            processData: false,
            success: function(url) {
                editor.insertImage(welEditable, url);
            }
        });
    }
</script>
@stop