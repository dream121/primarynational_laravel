@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/user') }}"><span class="glyphicon glyphicon-chevron-left"></span> Back to User list</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
             Add User
         </div>
         <div class="panel-body">

            {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'form')) }}

            <div class="form-group" >
                {{ Form::label('First Name : ') }}
                {{ Form::text('first_name','',array('class'=>'form-control','id'=>'first_name')) }}
                {{ $errors->first('first_name','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group" >
                {{ Form::label('Last Name : ') }}
                {{ Form::text('last_name','',array('class'=>'form-control','id'=>'last_name')) }}
                {{ $errors->first('last_name','<p class="text-red">:message</p>'); }}
            </div>
            <div class="form-group" >
                {{ Form::label('Agent ID : ') }}
                {{ Form::text('agent_id','',array('class'=>'form-control','id'=>'agent_id')) }}
                {{ $errors->first('agent_id','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::label('Email : ') }}
                {{ Form::text('email','',array('class'=>'form-control','id'=>'email')) }}
                {{ $errors->first('email','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::label('Phone : ') }}
                {{ Form::text('phone_number','',array('class'=>'form-control','id'=>'phone')) }}
                {{ $errors->first('phone_number','<p class="text-red">:message</p>'); }}
            </div>
            <div class="form-group" >
                {{ Form::label('Client Serve Limit : ') }}
                {{ Form::selectRange('client_serve_limit',1,20,'',array('class'=>'form-control','id'=>'client_serve_limit')) }}
                {{ $errors->first('client_serve_limit','<p class="text-red">:message</p>'); }}
            </div>
            <div class="form-group">
                {{ Form::label('Office Name : ') }}
                {{ Form::text('office_name','',array('class'=>'form-control','id'=>'office_name')) }}
                {{ $errors->first('office_name','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::label('Office Address : ') }}
                {{ Form::text('office_address_line1','',array('class'=>'form-control','id'=>'office_address_line1','placeholder'=>'Line 1')) }}
                {{ $errors->first('office_address_line1','<p class="text-red">:message</p>'); }}
                {{ Form::text('office_address_line2','',array('class'=>'form-control','id'=>'office_address_line2','placeholder'=>'Line 2')) }}
                {{ $errors->first('office_address_line2','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group form-tag" >
                {{ Form::label('Tag line : ') }}
                {{ Form::text('tagline','',array('class'=>'form-control tags','id'=>'tagline')) }}
                {{ $errors->first('tagline','<p class="text-red">:message</p>'); }}
            </div>



            <div class="form-group form-tag" >
                {{ Form::label('Job Title : ') }}
                {{ Form::text('designation','',array('class'=>'form-control tags','id'=>'designation')) }}
                {{ $errors->first('designation','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::label('Biography : ') }}
                {{ Form::textarea('biography',@$agent->biography,array('class'=>'form-control','id'=>'summernote')) }}
                {{ $errors->first('biography','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::label('Upload Photo') }}
                {{ Form::file('photo',array('class'=>'file')); }}
                {{ $errors->first('photo','<p class="text-red">:message</p>'); }}
            </div>

            <div class="form-group">
                {{ Form::submit('Save',array('id'=>'btn_save','class'=>'btn btn-primary')); }}
            </div>

            {{ Form::close() }}
        </div>
    </div>
</div>
</div>
@stop