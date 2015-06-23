@extends('layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-md-4">
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/post/create') }}">Add New Post</a>
    </div>
</div>

<div class="row"><h1/></div>



<div class="row">
    <div class="col-lg-12">
<div class="panel panel-default">
    <div class="panel-heading">
        Blog
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>Title</th>
                <th>Details</th>
                <th class="text-center"> Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($posts as $post)
        <tr>
           <td>{{ HTML::link('admin/blog/show/'.$post->id,$post->title) }}</td>
           <td>{{ $post->details }}</td>
           <td class="text-center">
               <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/blog/show/' . $post->id) }}">Show</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/blog/edit/'.$post->id) }}">Edit</a>
                
                <a href="{{ url('admin/blog/delete', $post->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i></a>

           </td>
        </tr>
        @endforeach

        </tbody>
    </table>
    <?php echo $posts->links(); ?>
        </div>
    </div>
    </div>

</div>
@stop
