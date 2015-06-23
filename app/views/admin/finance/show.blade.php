@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!--        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create_category/') }}">Add New Category</a>-->
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/finance') }}">Finance Page List</a>
    </div>

</div>
<div class="row"><h1/></div>

<div class="panel panel-default">
    <div class="panel-heading">
        Finance Page Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$finance->title}}</h2>
                <div class="row">
                    @if(!empty($finance->image_link_1))
                    <div class="col-lg-2"><span>Image 1</span><img style="border-radius: 5px;" src='{{$finance->image_link_1}}' height="150" width="150"></div>
                    @endif
                </div>
                <p><strong>Status :</strong> {{@$finance->status?'Active':'In Active'}}</p>
                <p><strong>Content :</strong> </p>
                <p>{{@$finance->content}}</p>
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$finance->user->first_name}} {{@$finance->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$finance->created_at}}</p>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop