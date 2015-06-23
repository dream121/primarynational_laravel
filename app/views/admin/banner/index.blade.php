@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/banner/create') }}">Add New Banner</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        Banner
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
		
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Image</th>
                <th>Link</th>
                <th>Status</th>
                <th class="text-center"> Action</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($banner as $banner_row)
        <tr>
           <td>
               @if(!empty($banner_row->image_link_1))
               <img class="img-responsive" src='{{url($banner_row->image_link_1)}}' width="150px">
               @endif
           </td>
            <td>{{ $banner_row->link }}</td>
            <td class="text-center">
                @if($banner_row->status)
                  <a class="btn btn-small btn-success" href="{{ URL::to('admin/banner/activate/'. $banner_row->id.'/no') }}" title="Click here to change status">Active</a>
                @else
                  <a class="btn btn-small btn-danger" href="{{ URL::to('admin/banner/activate/'. $banner_row->id.'/yes') }}">Inactive</a>
                @endif
            </td>
           <td class="text-center">
               <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-default" href="{{ URL::to('admin/banner/show/' . $banner_row->id) }}">Show</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/banner/edit/'.$banner_row->id) }}">Edit</a>
                
                <a class="btn btn-small btn-danger" href="{{ url('admin/banner/delete', $banner_row->id) }}"
                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>

           </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <?php echo $banner->links(); ?>
        </div>
    </div>
    </div>

</div>
@stop
