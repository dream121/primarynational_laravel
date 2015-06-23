@extends('layouts/default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
	<div class="width_90">
		<div class="agents_content clearfix">
			<div class="header_container">
				<h3><strong>{{ $agent->first_name }} {{$agent->last_name}}</strong></h3>
				<h4><em>{{ @$agent->profile->designation }} </em> | <em>{{ @$agent->email }} </em> </h4>
			</div>
			<br>
			<div class="col-md-6">
				<div class="row">
				@if($agent->profile->tagline)
					<h4><strong>{{$agent->profile->tagline}}</strong></h4>
				@endif
				<br>
				<p>
					@if(@$agent->profile->photo)
                    	<img src="<?=Croppa::url($agent->profile->photo, 225, 230, array('resize'))?>" alt="{{@$agent->first_name}} {{@$agent->last_name}}"/>
                    @endif
                    {{@$agent->profile->biography}}
                </p>
				</div>
			</div>
			<div class="col-md-5 col-md-offset-1">
				<div class="contact_box">
					<div class="box_header text-center">
						<h3>NEED HELP FINDING THE RIGHT AGENT</h3>
						<p>Tell us what you're looking for and we'll have an agent with experience in your area get in touch ASAP</p>
					</div>
					<form role="form">
						<div class="form-group">
							<label>First Name:</label>
							<input type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label>Last Name:</label>
							<input type="text" class="form-control">
						</div>
						<div class="form-group">
							<label>Email:</label>
							<input type="text" class="form-control" placeholder="">
						</div>
						<div class="form-group">
							<label>Phone No:</label>
							<input type="text" class="form-control" placeholder="(_ _ _) _ _ _ - _ _ _">
						</div>
						<div class="form-group">
							<label>
								Where are you buying or selling? <br>
								<span>Optional- this enables a more personal experiance</span>
							</label>

							<input type="text" class="form-control" placeholder="City States or ZIP">
						</div>

						<div class="form-group">
							<label>
								Comments/questions
							</label>
							<textarea class="form-control" cols="30" rows="5"></textarea>
						</div>

						<button class="btn btn-danger btn-block">Submit</button>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
@stop