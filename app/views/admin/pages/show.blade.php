@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header">{{$page_title}} <a class="btn btn-small btn-success pull-right" href="{{ URL::to('admin/page') }}"><< Back to Pages</a></h1>
    </div>
</div>

<div class="panel panel-default">
    <div class="panel-heading">
        Page Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$page->title}}</h2>
                <p>{{@$page->details}}</p>
                <p>{{@$page->order}}</p>

            </div>
        </div>

    </div>
   <!-- /.panel-body -->
</div>
@stop