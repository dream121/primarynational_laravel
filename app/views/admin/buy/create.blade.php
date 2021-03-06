@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="resource">
<div class="row">
    <div class="col-md-4">
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/buy') }}">Buy List</a>
    </div>
</div>
<div class="row"><h1/></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Add New Buy Page
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title','',array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>

                <!--<div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug','',array('class'=>'form-control','id'=>'slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}
                </div>-->
                <!--<div class="form-group" >
                    {{ Form::label('Link : ') }}
                    {{ Form::text('link','',array('class'=>'form-control','id'=>'link')) }}
                    {{ $errors->first('link','<p class="text-red">:message</p>'); }}
                </div>-->
                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content','',array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group file-control">
                    {{ Form::label('Image : ') }}
                    {{ Form::file('image_file[]',array('class'=>'file')); }}
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
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
            url: "<?=url('admin/upload/index/buy')?>",
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
    var prepare_tag= function(str)
    {
        var ftext = str;
        var s_ftext = ftext.split(',');
        var hiddentag='';
        for (i = 0; i<s_ftext.length; i++) {
            hiddentag+= '<input type="hidden" name="tag[title]['+i+']" value='+ s_ftext[i] +'>';
            hiddentag+= '<input type="hidden" name="tag[slug]['+i+']" value='+ slug(s_ftext[i]) +'>';
        }
        return hiddentag;
    }

    $("#title").keyup(function()
    {
        var slug1= slug($('#title').val());
        $("#slug").val(slug1);
    });

    var width= 0,
        height= 0;
    $('.file').on('change', function() {
        if(this.disabled) return alert('File upload not supported!');
        var F = this.files;
        if(F && F[0]) for(var i=0; i<F.length; i++) {
            readImage( F[i] );
        }
    });

    function readImage(file) {

        var reader = new FileReader();
        var image  = new Image();
        var w = 0,
            h = 0,
            t = null,                           // ext only: // file.type.split('/')[1],
            n = null,
            s = null;
        reader.readAsDataURL(file);
        reader.onload = function(_file) {

            image.src    = _file.target.result;              // url.createObjectURL(file);
            image.onload = function() {
                    w = this.width;
                    h = this.height;
                    t = file.type;                           // ext only: // file.type.split('/')[1],
                    n = file.name;
                    s = ~~(file.size/1024) +'KB';
                    setwidth(w,h);
                //console.log(w);
                //console.log('<img src="'+ this.src +'"> '+w+'x'+h+' '+s+' '+t+' '+n+'<br>');
            };

            console.log(w+'x'+h);
            /*image.onerror= function() {
                alert('Invalid file type: '+ file.type);
            };*/
        };

    }
    var setwidth=function(w,h)
    {
        width = w;
        height= h;
    }
    $("#choose").change(function (e) {
        if(this.disabled) return alert('File upload not supported!');
        var F = this.files;
        if(F && F[0]) for(var i=0; i<F.length; i++) readImage( F[i] );
    });

</script>
@stop
