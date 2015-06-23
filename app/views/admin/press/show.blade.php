@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<input id='content_type' type="hidden" name="type" value="resource">
<div class="row">
    <div class="col-lg-12">
        <!--        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create_category/') }}">Add New Category</a>-->
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/press') }}">Press List</a>
    </div>

</div>

<div class="row"><h1/></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Guide Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$press->title}}</h2>
                <p><strong>Slug :</strong> {{@$press->slug}}</p>
                <div class="row">
                    @if(!empty($press->image_link_1))
                    <div class="col-lg-2"><span>Image 1</span><img style="border-radius: 5px;" src='{{$press->image_link_1}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($press->image_link_2))
                    <div class="col-lg-2"><span>Image 2</span><img style="border-radius: 5px;" src='{{$press->image_link_2}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($press->image_link_3))
                    <div class="col-lg-2"><span>Image 3</span><img style="border-radius: 5px;" src='{{$press->image_link_3}}' height="150" width="150"></div>
                    @endif
                    @if(!empty($press->image_link_4))
                    <div class="col-lg-2"><span>Image 4</span><img style="border-radius: 5px;" src='{{$press->image_link_4}}' height="150" width="150"></div>
                    @endif
                </div>
                <p><strong>Status :</strong> {{@$press->status?'Active':'In Active'}}</p>
                <p><strong>Content :</strong> </p>
                <p>{{@$press->content}}</p>
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$press->user->first_name}} {{@$press->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$press->created_at}}</p>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop