@section('content')
<div class="container-fluid margin_top_after_sub_menu">
	<div class="col-md-3">
		<div class="profile_nav">
			@include('elements/account_menu')
		</div>

	</div>

	<div class="col-md-9">
		<div class="profile_header margin_bottom_30">
			<h2>My Profile</h2>
		</div>

		<div class="profile_content border border_radius_10 black_shadow">
			<h4>Contact info</h4>     <br>

			<form class="form-horizontal profile_form_1" id="contact_form" role="form">
				<div class="form-group">
					<label class="col-sm-2 control-label">Name:</label>
					<div class="col-sm-5">
						{{Form::text('first_name',Auth::user()->first_name,array("class"=>"form-control","required", "placeholder"=>"First Name"))}}
					</div>
					<div class="col-sm-5">
						{{Form::text('last_name',Auth::user()->last_name,array("class"=>"form-control","required","placeholder"=>"Last Name"))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-2 control-label">Phone:</label>
					<div class="col-sm-10">
						{{Form::text('phone',Auth::user()->phone_number,array("class"=>"form-control","required","placeholder"=>"Phone"))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">Address:</label>
					<div class="col-sm-10">
						{{Form::text('address_line1',Auth::user()->address_line1,array("class"=>"form-control","placeholder"=>"Address line 1"))}}
						{{Form::text('address_line2',Auth::user()->address_line2,array("class"=>"form-control","placeholder"=>"Address line 2"))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">City:</label>
					<div class="col-sm-10">
						{{Form::text('city',Auth::user()->city,array("class"=>"form-control","placeholder"=>"City"))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-2 control-label">State, Zip:</label>
					<div class="col-sm-5">
						{{Form::text('state',Auth::user()->state,array("class"=>"form-control","placeholder"=>"State"))}}
					</div>
					<div class="col-sm-5">
						{{Form::text('zip',Auth::user()->zip,array("class"=>"form-control","placeholder"=>"Zip"))}}
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
						{{Form::text('email',Auth::user()->email,array("class"=>"form-control",'disabled', "placeholder"=>"Email Address"))}}
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

			<form class="form-horizontal profile_form_1" action="{{url('change_password')}}" id="change_password_form" method="post" role="form">

				<div class="form-group">
					<label class="col-sm-4 control-label">Current Passwaord:</label>
					<div class="col-sm-8">
						{{Form::password('current_password',array("class"=>"form-control",'type'=>'password',"required", "placeholder"=>"Current Passwaord"))}}
					</div>
				</div>
				<div class="form-group">
					<label class="col-sm-4 control-label">New Password:</label>
					<div class="col-sm-8">
						{{Form::password('new_password',array("class"=>"form-control","required","id"=>"new_password", "placeholder"=>"New Passwaord"))}}
					</div>
				</div>

				<div class="form-group">
					<label class="col-sm-4 control-label">Confirm New Password:</label>
					<div class="col-sm-8">
						{{Form::password('new_password_confirmation',array("class"=>"form-control","required", "id"=>"new_password_confirmation", "placeholder"=>"Confirm New Passwaord"))}}
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-offset-2 col-sm-10">
						<button type="submit" class="btn btn-danger btn-lg pull-right btn-change_password">Save settings</button>
					</div>
				</div>

			</form>
		</div>
	</div>

</div>
@stop