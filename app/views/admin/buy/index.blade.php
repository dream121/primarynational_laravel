@extends('admin.layouts.default')

@section('content')

<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/welcome_note/create') }}">Add New Buy Page</a>
    </div>
</div>

<div class="row"><h1/></div>
<div class="row">
    <div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        Buy Page
    </div>
    <!-- /.panel-heading -->
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
        
        @foreach($buys as $buy)
        <tr>
           <td>{{ HTML::link('admin/buy/show/'.$buy->id,$buy->title) }}</td>
           <td>{{ substr(strip_tags($buy->content),0,50) }}</td>
            <td>{{ $buy->status? "Active":"Inactive" }}</td>
           <td class="text-center">
               @if($buy->status)
                <a class="btn btn-small btn-danger" href="{{ URL::to('admin/buy/activate/'. $buy->id.'/no') }}">De-Activate</a>
               @else
               <a class="btn btn-small btn-warning" href="{{ URL::to('admin/buy/activate/'. $buy->id.'/yes') }}">Activate</a>
               @endif
                <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/buy/show/' . $buy->id) }}">Show</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/buy/edit/'.$buy->id) }}">Edit</a>
                
                <a href="{{ url('admin/buy/delete', $buy->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i></a>

           </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <?php echo $buys->links(); ?>
        </div>
    </div>
    </div>

</div>
@stop
