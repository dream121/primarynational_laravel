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
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/welcome_note') }}">Welcome Note List</a>
    </div>

</div>
<div class="row"><h1/></div>

<div class="panel panel-default">
    <div class="panel-heading">
        Welcome Note Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$welcome_note->title}}</h2>
                <div class="row">
                    @if(!empty($welcome_note->image_link_1))
                    <div class="col-lg-2"><span>Image 1</span><img style="border-radius: 5px;" src='{{$welcome_note->image_link_1}}' height="150" width="150"></div>
                    @endif
                </div>
                <p><strong>Status :</strong> {{@$welcome_note->status?'Active':'In Active'}}</p>
                <p><strong>Content :</strong> </p>
                <p>{{@$welcome_note->content}}</p>
                <div class="clearfix"></div>
                <p><strong>Author :</strong> {{@$welcome_note->user->first_name}} {{@$welcome_note->user->last_name}}</p>
                <p><strong>Created :</strong> {{@$welcome_note->created_at}}</p>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop