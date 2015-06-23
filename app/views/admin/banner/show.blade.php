@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/banner/index') }}"><< Back</a></h1>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Banner Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$banner->title}}</h2>
                <p><strong>Link :</strong> {{@$banner->link}}</p>
                <div class="row">
                    @if(!empty($banner->image_link_1))
                    <div class="col-lg-12"><strong>Image :</strong><img class="img-responsive" src='{{url($banner->image_link_1)}}' width="90%"></div>
                    @endif
                </div>
                <p><strong>Status :</strong> {{@$banner->status?'Active':'Inactive'}}</p>
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$banner->user->first_name}} {{@$banner->user->last_name}}</p>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop
