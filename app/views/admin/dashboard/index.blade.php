@extends('admin.layouts.default')

@section('content')

<div class="row">
    <div class="col-lg-12">
        <h1>Dashboard <small>Statistics Overview</small></h1>
        <ol class="breadcrumb">
            <li class="active"><i class="fa fa-dashboard"></i> Dashboard</li>
        </ol>

    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <div class="panel panel-warning">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-user fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{url("admin/user/index/1")}}">
                            <p class="announcement-heading">{{$count_users}}</p>
                            <p class="announcement-text">New Users</p>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{url("admin/user")}}">
                            <div class="col-xs-6">
                                User List
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>

                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-comments fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{url("admin/comment/1")}}">
                            <p class="announcement-heading">{{@isset($count_comments)?$count_comments:'0'}}</p>
                            <p class="announcement-text">New Comments!</p>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a href="{{url("admin/comment")}}">
                            <div class="col-xs-6">
                                View Comments
                            </div>
                            <div class="col-xs-6 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-envelope fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{url("admin/feedback/category/showing/1")}}">
                            <p class="announcement-heading">{{@isset($count['showing'])?$count['showing']:'0'}}</p>
                            <p class="announcement-text">New Request!</p>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a  href="{{url("admin/feedback/category/showing")}}">
                            <div class="col-xs-10">
                                View All Requests
                            </div>
                            <div class="col-xs-2 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-btc fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{url("admin/feedback/category/buy/1")}}">
                            <p class="announcement-heading">{{@isset($count['buy'])?$count['buy']:'0'}}</p>
                            <p class="announcement-text">New Buy Request!</p>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a  href="{{url("admin/feedback/category/buy")}}">
                            <div class="col-xs-10">
                                View All Buy Requests
                            </div>
                            <div class="col-xs-2 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>
    <div class="col-lg-4">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-dollar fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <a href="{{url("admin/feedback/category/sell/1")}}">
                            <p class="announcement-heading">{{@isset($count['sell'])?$count['sell']:'0'}}</p>
                            <p class="announcement-text">New Sell Request!</p>
                        </a>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <a  href="{{url("admin/feedback/category/sell")}}">
                            <div class="col-xs-10">
                                View All Sell Requests
                            </div>
                            <div class="col-xs-2 text-right">
                                <i class="fa fa-arrow-circle-right"></i>
                            </div>
                        </a>
                    </div>
                </div>
            </a>
        </div>
    </div>

    <!--<div class="col-lg-3">
        <div class="panel panel-danger">
            <div class="panel-heading">
                <div class="row">
                    <div class="col-xs-6">
                        <i class="fa fa-tasks fa-5x"></i>
                    </div>
                    <div class="col-xs-6 text-right">
                        <p class="announcement-heading">18</p>
                        <p class="announcement-text">Crawl Errors</p>
                    </div>
                </div>
            </div>
            <a href="#">
                <div class="panel-footer announcement-bottom">
                    <div class="row">
                        <div class="col-xs-6">
                            Fix Issues
                        </div>
                        <div class="col-xs-6 text-right">
                            <i class="fa fa-arrow-circle-right"></i>
                        </div>
                    </div>
                </div>
            </a>
        </div>
    </div>-->
</div><!-- /.row -->
@stop
