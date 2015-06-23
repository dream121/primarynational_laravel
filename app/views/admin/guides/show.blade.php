@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/guide') }}"><< Back to Guide List</a></h1>
    </div>
</div>
<div class="panel panel-default">
    <div class="panel-heading">
        Guide Details <div class="pull-right">{{@$guide->status?'<span class="label label-success">Active</span>':'<span class="label label-danger">Inactive</span>'}}</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$guide->title}}</h2>

                <p><strong>Slug :</strong> {{@$guide->slug}}</p>
                <p><strong>Link :</strong> {{@$guide->link}}</p>
                <div class="row">
                    @if(!empty($guide->image_link_1))
                    <div class="col-lg-6"><span>Image</span> <br> <img  class="img-responsive" src='{{$guide->image_link_1}}' width="100%"></div>
                    @else

                    @endif
                </div>
                
                <p><strong>Content :</strong> </p>
                <p>{{@$guide->content}}</p>
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$guide->user->first_name}} {{@$guide->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$guide->created_at}}</p>

            </div>
        </div>

    </div>
</div>
@stop