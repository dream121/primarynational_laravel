@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/user/create') }}"><span class="glyphicon glyphicon-plus-sign"></span> Add New User</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Users
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Photo</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Designation</th>
                        <th>Role</th>
                        <th>Status</th>
                        <th>New User</th>
                        <th class="text-center"> Action</th>
                    </tr>
                    </thead>
                    <tbody>
	                    @if(!empty($agents) && !$agents->isEmpty())
		                    @foreach($agents as $agent)
			                    <tr>
			                    	<td>
			                    	@if(@$agent->profile->photo)
			                    	<img src="{{ @url($agent->profile->photo)}}" width="150px"></td>
			                    	@endif
			                        <td>{{ HTML::link('admin/user/show/'.$agent->id,$agent->first_name.' '.$agent->last_name) }}</td>
			                        <td>{{ $agent->email }}</td>
			                        <td>{{ @$agent->profile->designation }}</td>
			                        <td>{{ @$agent->role->name }}</td>
			                        <td>
			                            @if($agent->active)
			                                <a class="btn btn-small btn-success" href="{{ URL::to('admin/user/activate/'. $agent->id.'/no') }}" title="Click here to change status">Active</a>
			                            @else
			                                <a class="btn btn-small btn-danger" href="{{ URL::to('admin/user/activate/'. $agent->id.'/yes') }}" title="Click here to change status">Inactive</a>
			                            @endif
			                        </td>
									<td>
										@if($agent->recent_status)
										<a class="btn btn-warning" href="{{ URL::to('admin/user/reset-status/' . $agent->id.'/0') }}">Yes</a>
										@endif
									</td>
			                        <td class="text-center">
			                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
			                            <a class="btn btn-default" href="{{ URL::to('admin/user/show/' . $agent->id) }}">Show</a>

			                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
			                            <a class="btn btn-small btn-info"
			                               href="{{ URL::to('admin/user/edit/'.$agent->id) }}">Edit</a>

			                            <a class="btn btn-small btn-danger" href="{{ url('admin/user/delete', $agent->id) }}"
			                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
			                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>

			                        </td>
			                    </tr>
		                    @endforeach
	                    @else
	                    	<tr>
	                    		<td colspan="6" class="text-center">No User found</td>
	                    	</tr>
	                    @endif
                    </tbody>
                </table>
                <?php echo !empty($agents)?$agents->links():''; ?>
            </div>
        </div>
    </div>

</div>
@stop