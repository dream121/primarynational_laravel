
@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu">
	<div class="row">
		<div class="col-md-12">
			<div class="reset_password modal-dialog">
				<div class="profile_content border border_radius_10 black_shadow">
					@if (Session::has('error_msg'))
					<div class="alert alert-danger alert-dismissable" style="margin-top:10px">
						<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
						{{ Session::get('error_msg') }}
					</div>

					@endif
					<h4>Password Reset</h4> <br>

					{{ Form::open(array('url' => '/reset', 'class' => 'form-horizontal main_reset_form',"autocomplete"=>"off",'id'=>'main_reset_form', 'role'=>'form')); }}
					<input type="hidden" name="token" value="{{ $token }}">
					<div class="form-group">
						<label class="col-sm-4 control-label">Email:</label>
						<div class="col-sm-8">
							{{ Form::email('email','',array("class"=>"form-control", "placeholder"=>"name@website.com", "required", "name"=>"email", "autofocus")) }}
							{{ $errors->first('email','<p class="text-red">:message</p>'); }}
						</div>
					</div>

					<div class="form-group">
						<label class="col-sm-4 control-label">Password:</label>
						<div class="col-sm-8">
							<input class="form-control" placeholder="*********" required name="password" type="password" value="">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-4 control-label">Confirm Password:</label>
						<div class="col-sm-8">
							<input class="form-control" placeholder="*********" required name="password_confirmation" type="password" value="">
						</div>
					</div>
					<div class="form-group">
						<div class="col-sm-offset-4 col-sm-8">
							<button type="submit" class="btn btn-danger btn-login btn-lg pull-right">Reset Password</button>
						</div>
					</div>
					{{ Form::close() }}
				</div>
			</div>
		</div>
	</div>
</div>
@stop