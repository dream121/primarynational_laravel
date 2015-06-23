@extends('admin.layouts.default')
@section('content')
    <div class="row">
        <div class="col-lg-12 clearfix">
            <h1 class="page-header pull-left">{{$page_title}}</h1>
        </div>
    </div>
    <div class="row">
        <div class="col-lg-12">
            <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/feedback') }}">Feedback Page List</a>
        </div>

    </div>
    <div class="row"><h1/></div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Feedback Details
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">

                    <h2>Type:{{@$feedback->type}}</h2>
                    @foreach($feedback->toArray() as $key=>$value)
                        {{$value?"<p><strong>".ucwords(str_replace('_',' ',$key))." :</strong>".$value."</p>":''}}
                    @endforeach
                </div>
            </div>

        </div>
        <!-- /.panel-body -->
    </div>
@stop