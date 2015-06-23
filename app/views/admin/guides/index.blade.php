@extends('admin.layouts.default')

@section('content')

<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/guide/create') }}">Add New Guide</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        Guide
    </div>
    <div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Content</th>
                <th>Status</th>
                <th class="text-center"> Action</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($guides as $guide)
        <tr>
           <td>{{ HTML::link('admin/guide/show/'.$guide->id,$guide->title) }}</td>
           <td>{{ substr(strip_tags($guide->content),0,50) }}</td>
           <td class="text-center">
              @if($guide->status)
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/guide/activate/'. $guide->id.'/no') }}">Active</a>
              @else
                <a class="btn btn-small btn-danger" href="{{ URL::to('admin/guide/activate/'. $guide->id.'/yes') }}">Inactive</a>
              @endif
           </td>
           <td class="text-center">
                <a class="btn btn-small btn-default" href="{{ URL::to('admin/guide/show/' . $guide->id) }}">Show</a>
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/guide/edit/'.$guide->id) }}">Edit</a>
                <a class="btn btn-small btn-danger" href="{{ url('admin/guide/delete', $guide->id) }}"
                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>
               
           </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <?php echo $guides->links(); ?>
        </div>
    </div>
    </div>

</div>
@stop
