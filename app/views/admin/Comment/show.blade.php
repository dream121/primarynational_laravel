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
            <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/comment') }}">Comment Page List</a>
        </div>

    </div>
    <div class="row"><h1/></div>

    <div class="panel panel-default">
        <div class="panel-heading">
            Comment Details
        </div>
        <div class="panel-body">
            <div class="row">
                <div class="col-lg-12">

                    <h2>Blog:{{@$comment->blog->title}}</h2>
                    {{--<div class="row">--}}
                        {{--@if(!empty($buy->image_link_1))--}}
                            {{--<div class="col-lg-2"><span>Image 1</span><img style="border-radius: 5px;" src='{{$buy->image_link_1}}' height="150" width="150"></div>--}}
                        {{--@endif--}}
                    {{--</div>--}}
                    <p><strong>Author Name :</strong> {{@$comment->author_name}}</p>
                    <p><strong>Email:</strong>{{@$comment->author_email}} </p>
                    <p><strong>Phone Number:</strong>{{@$comment->phone_no}} </p>
                    <p><strong>IP :</strong>{{@$comment->author_ip}} </p>
                    <p><strong>URL :</strong>{{@$comment->author_url}} </p>
                    <p><strong>New :</strong>{{@$comment->recent_status?'New':'Old'}} </p>
                    <p><strong>Approved :</strong>{{@$comment->approved?'Yes':'No'}} </p>
                    <p><strong>Comment :</strong>{{@$comment->comment}}</p>
                    <div class="clearfix"></div>
                    <p><strong>Created :</strong> {{@$comment->created_at}}</p>

                </div>
            </div>

        </div>
        <!-- /.panel-body -->
    </div>
@stop