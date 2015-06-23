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
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/social_media') }}">Social Media List</a>
    </div>

</div>
<div class="row"><h1/></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Social Media Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$social_media->title}}</h2>
                <p><strong>Slug :</strong> {{@$social_media->slug}}</p>
                <p><strong>Link :</strong> {{@$social_media->link}}</p>
                <div class="row">
                    @if(!empty($social_media->image_link_1))
                    <div class="col-lg-2"><strong>Icon :</strong><img style="border-radius: 5px;" src='{{$social_media->image_link_1}}' height="150" width="150"></div>
                    @endif
                </div>
                <p><strong>Status :</strong> {{@$social_media->status?'Active':'Inactive'}}</p>
                <!--<p><strong>Content :</strong> </p>
                <p>{{@$social_media->content}}</p>-->
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$social_media->user->first_name}} {{@$social_media->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$social_media->created_at}}</p>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop
