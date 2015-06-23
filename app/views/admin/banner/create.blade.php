@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/banner') }}">Banner List</a></h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="resource">

<div class="panel panel-default">
    <div class="panel-heading">
        Add New Banner
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Name : ') }}
                    {{ Form::text('title','',array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group" >
                    {{ Form::label('Link : ') }}
                    {{ Form::text('link','',array('class'=>'form-control','id'=>'link')) }}
                    {{ $errors->first('link','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group file-control">
                    {{ Form::label('Upload Image : ') }}
                    {{ Form::file('image_file',array('class'=>'file')); }}
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
                    <span class="help-block">For better fit upload image with 1800x900px.</span>
                </div>
                <div class="checkbox">
                    <label>
                        {{ Form::checkbox('status') }} Is Active?
                    </label>
                </div>
                <div class="form-group">
                    {{ Form::submit('Save',array('class'=>'btn btn-primary')); }}

                </div>

                {{ Form::close() }}

            </div>
        </div>

    </div>
</div>
</div>

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
/*    $('.file').on('change', function() {
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
            *//*image.onerror= function() {
                alert('Invalid file type: '+ file.type);
            };*//*
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
     */
    $('.file').on('change', function() {
        if(this.disabled) return alert('File upload not supported!');
        /*var F = this.files;
        if(F && F[0]) for(var i=0; i<F.length; i++) {
            readImage( F[i] );
        }*/
        loadImage;
    });
    function loadImage() {
        var input, file, fr, img;

        if (typeof window.FileReader !== 'function') {
            write("The file API isn't supported on this browser yet.");
            return;
        }

        input = document.getElementById('imgfile');
        if (!input) {
            write("Um, couldn't find the imgfile element.");
        }
        else if (!input.files) {
            write("This browser doesn't seem to support the `files` property of file inputs.");
        }
        else if (!input.files[0]) {
            write("Please select a file before clicking 'Load'");
        }
        else {
            file = input.files[0];
            fr = new FileReader();
            fr.onload = createImage;
            fr.readAsDataURL(file);
        }

        function createImage() {
            img = document.createElement('img');
            img.onload = imageLoaded;
            img.style.display = 'none'; // If you don't want it showing
            img.src = fr.result;
            document.body.appendChild(img);
        }

        function imageLoaded() {
            write(img.width + "x" + img.height);
            // This next bit removes the image, which is obviously optional -- perhaps you want
            // to do something with it!
            img.parentNode.removeChild(img);
            img = undefined;
        }

        function write(msg) {
            var p = document.createElement('p');
            p.innerHTML = msg;
            document.body.appendChild(p);
        }
    }

</script>
@stop
