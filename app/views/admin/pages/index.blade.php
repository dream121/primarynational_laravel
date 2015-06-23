@extends('admin.layouts.default')

@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right"
                                                   href="{{ URL::to('admin/page/create') }}">Add New Page</a></h1>
    </div>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="panel panel-default">
            <div class="panel-heading">
                Pages
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
                    @foreach($pages as $page)
                    <tr>
                        <td>{{ HTML::link('admin/page/show/'.$page->id,$page->title) }}</td>
                        <td>{{ substr(strip_tags($page->details),0,50) }}</td>
                        <td class="text-center">
                            <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                            <a class="btn btn-small btn-success" href="{{ URL::to('admin/page/show/' . $page->id) }}">Show</a>

                            <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                            <a class="btn btn-small btn-info"
                               href="{{ URL::to('admin/page/edit/'.$page->id) }}">Edit</a>

                            <a class="btn btn-small btn-danger" href="{{ url('admin/page/delete', $page->id) }}"
                               onclick="if(!confirm('Are you sure to delete this item?')){return false;};"
                               title="Delete this Item"><span class="glyphicon glyphicon-remove"></span></a>

                        </td>
                    </tr>
                    @endforeach

                    </tbody>
                </table>
                <?php echo $pages->links(); ?>
            </div>
        </div>
    </div>

</div>
@stop
