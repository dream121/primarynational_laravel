@extends('layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <!--        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/resource/create_category/') }}">Add New Category</a>-->
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/post') }}">Post List</a>
    </div>

</div>
<div class="row"><h1/></div>
<div class="panel panel-default">
    <div class="panel-heading">
        Blog Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$post->title}}</h2>
                <p>{{@$post->content}}</p>

            </div>
        </div>

    </div>
   <!-- /.panel-body -->
</div>
@stop