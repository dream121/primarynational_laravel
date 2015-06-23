@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} {{--<a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/feedback/create') }}"><span class="glyphicon glyphicon-plus-sign"></span> Add New Feedback</a>--}}</h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                {{@$type_title}}
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>ID</th>
                        <th>Blog</th>
                        <th>Author Name</th>
                        <th>Email</th>
                        <th>Phone Number</th>
                        <th>IP</th>
                        <th>Comment</th>
                        <th>Recent</th>
                        <th>Approval</th>
                        <th class="text-center"> Action</th>
                    </tr>
                    </thead>
                    <tbody>
	                    @if(!$comments->isEmpty())
		                    @foreach($comments as $feedback)
			                    <tr>
			                    	<td>{{@$feedback->id}}</td>
			                    	<td>{{@$feedback->Blog->id}}</td>
			                        <td>{{ HTML::link('admin/comment/show/'.$feedback->id,@$feedback->author_name) }}</td>
			                        <td>{{ $feedback->author_email }}</td>
			                        <td>{{ @$feedback->phone_no}}</td>
			                        <td>{{ @$feedback->author_ip}}</td>
			                        <td> {{ @$feedback->comment}}</td>
			                        <td> <a class="btn {{ @$feedback->recent_status?'btn-success':'btn-danger'}}" href="{{ URL::to('admin/comment/reset_status/' . $feedback->id.'/'.($feedback->recent_status?'0':'1')) }}">{{ @$feedback->recent_status?'New':'Old'}}</a></td>
                                    <?php
                                    $approval_toggle=$feedback->approved?0:1;
                                    $approval_text=$feedback->approved?'<i class="fa fa-check"></i>':'<i class="fa fa-close"></i>';
                                    ?>
                                    <td class="text-center"> <a class="btn_approval btn btn-success" href="{{ URL::to('admin/comment/approval/' . $feedback->id.'/'.$approval_toggle) }}">{{$approval_text}}</a></td>
			                        <td class="text-center">
			                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
			                            <a class="btn btn-default" href="{{ URL::to('admin/comment/show/' . $feedback->id) }}">Show</a>

			                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
			                            {{--<a class="btn btn-small btn-info"--}}
			                               {{--href="{{ URL::to('admin/feedback/edit/'.$feedback->id) }}">Edit</a>--}}

			                            <a class="btn btn-small btn-danger" href="{{ url('admin/comment/delete', $feedback->id) }}"
			                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
			                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>

			                        </td>
			                    </tr>
		                    @endforeach
	                    @else
	                    	<tr>
	                    		<td colspan="10" class="text-center">No Feedback found</td>
	                    	</tr>
	                    @endif
                    </tbody>
                </table>
                <?php echo $comments->links(); ?>
            </div>
        </div>
    </div>

</div>
@stop