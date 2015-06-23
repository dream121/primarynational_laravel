@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
{{--<div class="row">--}}
    {{--<div class="col-lg-12">--}}
        {{--<a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/agent') }}">Agent Page List</a>--}}
    {{--</div>--}}

{{--</div>--}}
<div class="row"><h1/></div>

<div class="panel panel-default">
    <div class="panel-heading">
        Account Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-md-9">
                <div class="profile_content border border_radius_10 black_shadow">
                    <h4>Contact info</h4>     <br>

                    <form class="form-horizontal profile_form_1" id="contact_form" role="form" method="POST" enctype="multipart/form-data">
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Name:</label>
                            <div class="col-sm-5">
                                {{Form::text('first_name',$user->first_name,array("class"=>"form-control","required", "placeholder"=>"First Name"))}}
                            </div>
                            <div class="col-sm-5">
                                {{Form::text('last_name',$user->last_name,array("class"=>"form-control","required","placeholder"=>"Last Name"))}}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Phone:</label>
                            <div class="col-sm-10">
                                {{Form::text('phone_number',$user->phone_number,array("class"=>"form-control","required","placeholder"=>"Phone"))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Address:</label>
                            <div class="col-sm-10">
                                {{Form::text('address_line1',$user->address_line1,array("class"=>"form-control","placeholder"=>"Address line 1"))}}
                                {{Form::text('address_line2',$user->address_line2,array("class"=>"form-control","placeholder"=>"Address line 2"))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">City:</label>
                            <div class="col-sm-10">
                                {{Form::text('city',$user->city,array("class"=>"form-control","placeholder"=>"City"))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-2 control-label">State, Zip:</label>
                            <div class="col-sm-5">
                                {{Form::text('state',$user->state,array("class"=>"form-control","placeholder"=>"State"))}}
                            </div>
                            <div class="col-sm-5">
                                {{Form::text('zip',$user->zip,array("class"=>"form-control","placeholder"=>"Zip"))}}
                            </div>
                        </div>
                        <div class="form-group" >
                            {{ Form::label('Client Serve Limit : ','client_serve_limit',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::selectRange('client_serve_limit',1,20,$user->client_serve_limit,array('class'=>'form-control','id'=>'client_serve_limit')) }}
                                {{ $errors->first('client_serve_limit','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>

                        <div class="form-group" >
                            {{ Form::label('Client Served Currently: ','client_served',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::selectRange('client_served',1,20,$user->client_served,array('class'=>'form-control','id'=>'client_served')) }}
                            {{ $errors->first('client_served','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            {{ Form::label('Office Name : ','office_name',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::text('office_name',@$user->profile->office_name,array('class'=>'form-control','id'=>'phone')) }}
                            {{ $errors->first('office_name','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Office Address : ','office_address_line1',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::text('office_address_line1',@$user->profile->office_address_line1,array('class'=>'form-control','id'=>'address_line1','placeholder'=>'Line 1')) }}
                            {{ $errors->first('office_address_line1','<p class="text-red">:message</p>'); }}
                            </div>
                                <div class="col-sm-5">
                                    {{ Form::text('office_address_line2',@$user->profile->office_address_line2,array('class'=>'form-control','id'=>'address_line2','placeholder'=>'Line 2')) }}
                            {{ $errors->first('office_address_line2','<p class="text-red">:message</p>'); }}
                                </div>
                        </div>

                        <div class="form-group form-tag" >
                            {{ Form::label('Tag line : ','tagline',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::text('tagline',@$user->profile->tagline,array('class'=>'form-control tags','id'=>'tagline')) }}
                            {{ $errors->first('tagline','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group form-tag" >
                            {{ Form::label('Job Title : ','designation',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-5">
                                {{ Form::text('designation',@$user->profile->designation,array('class'=>'form-control tags','id'=>'designation')) }}
                            {{ $errors->first('designation','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>

                        <div class="form-group">
                            {{ Form::label('Biography : ','biography',array('class'=>'col-sm-2 control-label')) }}
                            <div class="col-sm-10">
                                {{ Form::textarea('biography',@$user->profile->biography,array('class'=>'form-control','id'=>'summernote')) }}
                            {{ $errors->first('biography','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-2 control-label">Photo:</label>
                            <div class="col-sm-5">
                                @if(@$user->profile->photo)
                                    <img src="{{url($user->profile->photo)}}" > <br>
                                @endif

                                {{ Form::label('Upload Photo') }}
                                {{ Form::file('photo',array('class'=>'file')); }}
                                {{ $errors->first('photo','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger btn-lg pull-right btn-contact">Save settings</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="profile_content border_radius_10 black_shadow">
                    <h4>Email addresses</h4>               <br>

                    <form class="form-horizontal profile_form_1" role="form">

                        <div class="form-group">
                            <label class="col-sm-2 control-label">Email:</label>
                            <div class="col-sm-10">
                                {{Form::text('email',$user->email,array("class"=>"form-control",'disabled', "placeholder"=>"Email Address"))}}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="button" class="btn btn-danger btn-lg pull-right" disabled="disabled">Save settings</button>
                            </div>
                        </div>
                    </form>
                </div>

                <div class="profile_content border_radius_10 black_shadow">
                    <h4>Password</h4><br>

                    <form class="form-horizontal profile_form_1" action="{{url('admin/change_password')}}" id="change_password_form" method="post" role="form">

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Current Passwaord:</label>
                            <div class="col-sm-8">
                                {{Form::password('current_password',array("class"=>"form-control",'type'=>'password',"required", "placeholder"=>"Current Passwaord"))}}
                                {{ $errors->first('current_password','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>
                        <div class="form-group">
                            <label class="col-sm-4 control-label">New Password:</label>
                            <div class="col-sm-8">
                                {{Form::password('new_password',array("class"=>"form-control","required","id"=>"new_password", "placeholder"=>"New Passwaord"))}}
                                {{ $errors->first('new_password','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="col-sm-4 control-label">Confirm New Password:</label>
                            <div class="col-sm-8">
                                {{Form::password('new_password_confirmation',array("class"=>"form-control","required", "id"=>"new_password_confirmation", "placeholder"=>"Confirm New Passwaord"))}}
                                {{ $errors->first('new_password_confirmation','<p class="text-red">:message</p>'); }}
                            </div>
                        </div>

                        <div class="form-group">
                            <div class="col-sm-offset-2 col-sm-10">
                                <button type="submit" class="btn btn-danger btn-lg pull-right btn-change_password">Change Password</button>
                            </div>
                        </div>

                    </form>
                </div>
            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop