@extends('layouts.default')

@section('content')
<script src="//tinymce.cachefly.net/4.0/tinymce.min.js"></script>
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1> {{link_to('admin/page/create','Add New Page',array('class'=>'pull-right'))}}
    </div>

</div>
<?php var_dump($errors)?>
<div class="panel panel-default">
    <div class="panel-heading">
        Add New Post
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true)) }}
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title','',array('class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug','',array('class'=>'form-control')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}

                </div>

                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content','',array('class'=>'form-control')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status') }}
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
    tinymce.init({
        selector: "textarea",
        theme: "modern",
        plugins: [
            "advlist autolink link image lists charmap print preview hr anchor pagebreak spellchecker",
            "searchreplace wordcount visualblocks visualchars code fullscreen insertdatetime media nonbreaking",
            "save table contextmenu directionality emoticons template paste textcolor"
        ],
        toolbar: "insertfile undo redo | styleselect | bold italic | alignleft aligncenter alignright alignjustify | bullist numlist outdent indent | l      ink image | print preview media fullpage | forecolor backcolor emoticons",
        style_formats: [
            {title: 'Bold text', inline: 'b'},
            {title: 'Red text', inline: 'span', styles: {color: '#ff0000'}},
            {title: 'Red header', block: 'h1', styles: {color: '#ff0000'}},
            {title: 'Example 1', inline: 'span', classes: 'example1'},
            {title: 'Example 2', inline: 'span', classes: 'example2'},
            {title: 'Table styles'},
            {title: 'Table row 1', selector: 'tr', classes: 'tablerow1'}
        ]
    });
</script>
@stop
