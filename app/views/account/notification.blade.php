@section('content')
<div class="container-fluid margin_top_after_sub_menu">
	<div class="col-md-3">
		<div class="profile_nav">
			@include('elements/account_menu')
		</div>

	</div>

	<div class="col-md-8">
		<div class="profile_header margin_bottom_30">
			<h2>Saved Searches & Listing Alerts</h2>
		</div>
		@if (Session::has('error_msg'))
		<div class="alert alert-danger alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{{ Session::get('error_msg') }}
		</div>

		@endif
		@if (Session::has('success_msg'))
		<div class="alert alert-success alert-dismissable">
			<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
			{{ Session::get('success_msg') }}
		</div>

		@endif

		<div class="profile_content border border_radius_10 black_shadow">
			<h4>Saved Searchs</h4>     <br>
			<table class="table table-bordered">
				<tr>
					<th>Search</th>
					<th>Search Link</th>
					<th>Alert</th>
					<th>Interval</th>
					<th>Action</th>
				</tr>
				@foreach($save_searches as $save_search)
				<tr>
					<td>{{$save_search->search_name}}</td>
					<td>{{str_replace('&',', ',urldecode($save_search->search_link))}}</td>
					<td>{{@$save_search->email_alert?'Yes':'No'}}</td>
					<td>{{$save_search->email_interval}}</td>
					<td>
						<a class="btn btn-default" href="{{ URL::to('search?' . $save_search->search_link) }}">Go</a>

						<!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
						{{--<a class="btn btn-small btn-info"--}}
						   {{--href="{{ URL::to('admin/agent/edit/'.$agent->id) }}">Edit</a>--}}

						<a class="btn btn-small btn-danger" href="{{ url('notification/delete', $save_search->id) }}"
						   onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
						   title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>
					</td>
				</tr>
				@endforeach
			</table>
		</div>
		<div class="profile_content border border_radius_10 black_shadow">
			<h4>Email Preferences</h4>     <br>

			<form class="form-horizontal profile_form_1" role="form">

				<div class="form-group">
					<div class="col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Allow periodic emails from our <strong><em>real estate team</em></strong>
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Allow periodic emails from a   <strong><em>trusted local lender</em></strong>
							</label>
						</div>
					</div>
				</div>

				<div class="form-group">
					<div class="col-sm-10">
						<div class="checkbox">
							<label>
								<input type="checkbox"> Allow us to send new  <strong><em>listing e-Alerts</em></strong> of saved searches
							</label>
						</div>
					</div>
				</div>

				<br>
				<div class="form-group">
					<div class="col-sm-12 text-center ma">
						<button type="submit" class="btn btn-danger btn-lg">Update Email Preferences</button>
					</div>
				</div>
				<br>

				<div class="text-right">
					<span>Stop all communication from this site... </span>
					<button class="btn btn-default btn-lg btn-unsub"> Unsubscribe</button>
				</div>
			</form>
		</div>

	</div>

</div>
@stop



