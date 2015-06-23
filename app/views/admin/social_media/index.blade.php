@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/social_media/create') }}">Add New Social Media</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        Social Media
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
		
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Name</th>
                <th>Icon</th>
                <th>Link</th>
                <th>Status</th>
                <th class="text-center"> Action</th>
            </tr>
        </thead>
        <tbody>
        
        @foreach($social_media as $social_media_row)
        <tr>
            <td>{{ HTML::link('admin/social_media/show/'.$social_media_row->id,$social_media_row->title) }}</td>
            <td>@if(!empty($social_media_row->image_link_1))
                <img style="border-radius: 5px;" src='{{ $social_media_row->image_link_1 }}' height="75" width="75">
                @endif</td>
            <td>{{ $social_media_row->link }}</td>
            <td>{{ $social_media_row->status? "Active":"Inactive" }}</td>
            <td class="text-center">
                @if($social_media_row->status)
                <a class="btn btn-small btn-danger" href="{{ URL::to('admin/social_media/activate/'. $social_media_row->id.'/no') }}">De-Activate</a>
                @else
                <a class="btn btn-small btn-warning" href="{{ URL::to('admin/social_media/activate/'. $social_media_row->id.'/yes') }}">Activate</a>
                @endif
               <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/social_media/show/' . $social_media_row->id) }}">Show</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/social_media/edit/'.$social_media_row->id) }}">Edit</a>
                
                <a href="{{ url('admin/social_media/delete', $social_media_row->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i></a>

            </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <?php echo $social_media->links(); ?>
        </div>
    </div>
    </div>

</div>
@stop
