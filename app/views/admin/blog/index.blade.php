@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/blogs/create') }}"><span class="glyphicon glyphicon-plus-sign"></span> Add New Blog</a></h1>
    </div>
</div>

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
                        <th>Content</th>
                        <th>Status</th>
                        <th class="text-center"> Action</th>
                    </tr>
                    </thead>
                    <tbody>

                    @foreach($blogs as $blog)
                    <tr>

                        <td>{{ HTML::link('admin/blogs/show/'.$blog->id,$blog->title) }}</td>
                        <td><p>{{ Str::words(strip_tags($blog->content),10) }}</p></td>
                        <td> 
                            @if($blog->status)
                                <a class="btn btn-small btn-success" href="{{ URL::to('admin/blogs/activate/'. $blog->id.'/no') }}" title="Click here to change status">Active</a>
                            @else
                                <a class="btn btn-small btn-danger" href="{{ URL::to('admin/blogs/activate/'. $blog->id.'/yes') }}" title="Click here to change status">Inactive</a>
                            @endif
                        </td>
                        <td class="text-center">
                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-default" href="{{ URL::to('admin/blogs/show/' . $blog->id) }}">Show</a>

                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-info"
                               href="{{ URL::to('admin/blogs/edit/'.$blog->id) }}">Edit</a>

                            <a class="btn btn-small btn-danger" href="{{ url('admin/blogs/delete', $blog->id) }}"
                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>

                        </td>

                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <?php echo $blogs->links(); ?>
            </div>
        </div>
    </div>

</div>
@stop
