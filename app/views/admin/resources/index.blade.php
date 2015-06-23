@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create') }}">Add New Resource</a>
    </div>
</div>

<div class="row"><h1/></div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Resources
            </div>
            <!-- /.panel-heading -->
            <div class="panel-body">
                <table class="table table-striped table-bordered table-hover">
                    <thead>
                    <tr>
                        <th>Title</th>
                        <th>Slug</th>
                        <th>Type</th>
                        <th>Category</th>
                        <th>Total Comment</th>
                        <th>Status</th>
                        <th class="text-center">Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($resources as $resource)
                    <tr>
                        <td>{{ HTML::link('admin/resource/show/'.$resource->id,$resource->title) }}</td>
                        <td>{{ $resource->slug }}</td>
                        <td>{{ $resource->type }}</td>
                        <td>
                            @if($resource->category_id>0)
                            {{ $resource->category->name }}
                            @else
                            N/A
                            @endif

                        </td>
                        <td>{{ $resource->comment_count }}</td>
                        <td>{{Util::getStatus($resource->status )}}</td>
                        <td class="text-center">
                            @if($resource->status)
                            <a class="btn btn-small btn-danger" href="{{ URL::to('admin/resource/activate/'. $resource->id.'/no') }}">De-Activate</a>
                            @else
                            <a class="btn btn-small btn-warning" href="{{ URL::to('admin/resource/activate/'. $resource->id.'/yes') }}">Activate</a>
                            @endif
                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-success" href="{{ URL::to('admin/resource/show/' . $resource->id) }}">Show</a>

                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-info" href="{{ URL::to('admin/resource/edit/'.$resource->id) }}">Edit</a>

                            <a href="{{ url('admin/resource/delete', $resource->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i></a>

                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <?php echo $resources->links(); ?>
            </div>
        </div>
    </div>
</div>
@stop
