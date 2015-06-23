@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">Resource details</h1>
    </div>


</div>

<div class="row">
    <div class="col-lg-12"> <strong>Title:</strong><span> {{$resource->title}}</span></div>
    <div class="col-lg-12"> <strong>Slug:</strong> <span>{{$resource->slug}}</span></div>
    <div class="col-lg-12"> <strong><strong>Status:</strong> <span>{{Util::getStatus($resource->status)}}</span></div>
    <div class="col-lg-12"> <strong>Total comment:</strong> <span> {{$resource->comment_count}}</span></div>

    <div class="col-lg-12"><strong>Content</strong></div>
    <div class="col-lg-12"><h5>{{$resource->content}}</h5></div>

</div>

@stop
