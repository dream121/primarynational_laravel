@extends('admin.layouts.default')
@section('content')
{{ HTML::script('assets/js/resource/category-manage.js') }}
<!--<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>-->
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/blogs') }}">Blog List</a></h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="blog">
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
        Add New Blog
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group">
                    {{ Form::label('Select a category:', 'Select a category');}}
                    {{ Form::select('category_id', array('' => 'Select One category') + $categories, Input::old('category_id'),array('class'=>'ddlCategory')) }}
                    <a href="{{url('/admin/category')}}" class="btn btn-primary manage-category" >
                        Manage category
                    </a>
                </div>
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title','',array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug','',array('class'=>'form-control','id'=>'slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}

                </div>
                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status') }}
                </div>
                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content','',array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group form-tag" >
                    {{ Form::label('Tag : ') }}
                    {{ Form::text('tag','',array('class'=>'form-control tags','id'=>'tag')) }}
                    {{ $errors->first('tag','<p class="text-red">:message</p>'); }}
                {{--</div>--}}
                {{--<div class="form-group">--}}
                    {{--{{ Form::label('image_upload_status','Do You Want To Upload Images? : ') }}--}}
                    {{--{{ Form::checkbox('image_upload_status','',false,array('id'=>'image_upload_status')) }}--}}
                    {{--{{ $errors->first('image_upload_status','<p class="text-red">:message</p>'); }}--}}
                {{--</div>--}}
                <div class="form-group file-control">
                    {{ Form::label('Images : ') }}
                    {{ Form::file('image_file',array('class'=>'file')); }}
                    {{--<a class='add_more' href=''>Add More</a>--}}
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group">
                    {{ Form::submit('Save',array('id'=>'btn_save','class'=>'btn btn-primary')); }}

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


	$('#image_upload_status').click(function()
	{
		if($(this).is(':checked'))
			$('.file-control').removeClass('hide');
		else
			$('.file-control').addClass('hide');
	});
    var  count=0;
//	$('#form').on('change','.file',function(event)
//	{
////		event.preventDefault();
//        if(count<3){
//            var htmlImage = '<input class="file" type="file" name="image_file[]">';
//            $(this).after(htmlImage);
////            $(this).remove();
//        }
//        count++;
//
//	});

    $('#tag').tagsInput({
        width: 'auto',
        autocomplete_url:'<?=url('admin/blogs/search')?>' // jquery ui autocomplete requires a json endpoint
    });

</script>
@stop
