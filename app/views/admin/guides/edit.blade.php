@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/guide') }}"><< Back to Guide List</a></h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Update Guide
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}
                <div class="form-group" >
                    {{ Form::label('Title : ') }}
                    {{ Form::text('title',$guide->title,array('id'=>'title','class'=>'form-control')) }}
                    {{ $errors->first('title','<p class="text-red">:message</p>'); }}

                </div>
                <div class="form-group" >
                    {{ Form::label('Slug : ') }}
                    {{ Form::text('slug',$guide->slug,array('class'=>'form-control','id'=>'slug')) }}
                    {{ $errors->first('slug','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group" >
                    {{ Form::label('State : ') }}
                    {{Form::select('state', array('Select State')+$states,@$guide->state,array('id'=>'state_drop','class'=>'form-control'))}}
                    {{ $errors->first('state','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group city" >
                    {{ Form::label('City : ') }}
                    @foreach($cities as $key=>$city_list)
                        @if($key==$guide->state)
                            {{Form::select('city', array('Select City')+$city_list,@$guide->city,array('id'=>str_replace(' ','_',$key),'class'=>'form-control city_drop '))}}
                        @else
                            {{Form::select('city', array('Select City')+$city_list,@$guide->city,array('id'=>str_replace(' ','_',$key),'class'=>'form-control city_drop hidden','disabled'=>'disabled'))}}
                        @endif
                    @endforeach
                    {{ $errors->first('city','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group" >
                    {{ Form::label('Link : ') }}
                    {{ Form::text('link',$guide->link,array('class'=>'form-control','id'=>'link')) }}
                    {{ $errors->first('link','<p class="text-red">:message</p>'); }}
                </div>
                <div class="form-group">
                    {{ Form::label('Is Active?')}}
                    {{ Form::checkbox('status', $guide->status, $guide->status) }}
                </div>
                <div class="form-group file-control row">
                    @if($guide->image_link_1)
                    <div class="col-lg-2 ">
                        @if($guide->image_link_1)
                        <img style="border-radius: 5px;" src={{url($guide->image_link_1) }} height="100" width="100">
                        @endif
                    </div>
                    @endif
                    <div class="col-lg-5">
                    {{ Form::label('Main Image : ') }}
                    {{ Form::file('image_file'); }}
                    {{ $errors->first('image_file','<p class="text-red">:message</p>'); }}
                     </div>

                </div>
                <div class="form-group">
                    {{ Form::label('Content : ') }}
                    {{ Form::textarea('content',$guide->content,array('class'=>'form-control','id'=>'summernote')) }}
                    {{ $errors->first('content','<p class="text-red">:message</p>'); }}
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
    $("#state_drop").change(function(e){
        var state=$(this).val().replace(' ','_');
        console.log(state);
        $(".city").removeClass('hidden');
        $(".city_drop").addClass('hidden').attr('disabled','disabled');
        $("#"+state).removeClass('hidden').removeAttr('disabled');
    });
</script>
@stop
