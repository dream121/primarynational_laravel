@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu">
	<div class="row">
		<div class="col-md-12">
			<div class="log_in modal-dialog">
				<div class="profile_content border border_radius_10 black_shadow">
					@if (Session::has('message'))
					<div class="alert alert-success alert-dismissable" style="margin-top:10px">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{ Session::get('message') }}
					</div>

					@endif
					@if (Session::has('error_msg'))
					<div class="alert alert-danger alert-dismissable" style="margin-top:10px">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{ Session::get('error_msg') }}
					</div>

					@endif
					<h4>Please Log In To Manage Your Account</h4> <br>
					
					{{ Form::open(array('url' => 'login', 'class' => 'form-horizontal profile_login_form',"autocomplete"=>"off",'id'=>'main_login_form', 'role'=>'form')); }}
					<div class="form-group">
						<label class="col-sm-2 control-label">Email:</label>
						<div class="col-sm-10">
							{{ Form::email('email','',array("class"=>"form-control", "placeholder"=>"name@website.com", "required", "name"=>"email", "autofocus")) }}
							{{ $errors->first('email','<p class="text-red">:message</p>'); }}
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-2 control-label">Password:</label>
						<div class="col-sm-10">
							<input class="form-control" placeholder="*********" required name="password" type="password" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10 text-right">

							<a href="#" data-toggle="modal"  data-target="#forgot_pass" class="forgot_pass" >Forgot Password</a>

						</div>
					</div>

					<div class="form-group">
						<div class="col-sm-offset-2 col-sm-10">
							<button type="submit" class="btn btn-danger btn-login btn-lg pull-right">Login</button>
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@stop