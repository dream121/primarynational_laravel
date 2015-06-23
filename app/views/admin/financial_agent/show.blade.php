@extends('admin.layouts.default')
@section('content')
<div class="row">
    <div class="col-lg-12 clearfix">
        <h1 class="page-header pull-left">{{$page_title}}</h1>
    </div>
</div>
<div class="row">
    <div class="col-lg-12">
        <a class="btn btn-small btn-success pull-left" href="{{ URL::to('admin/financial-agent') }}">Financial Agent Page List</a>
    </div>

</div>
<div class="row"><h1/></div>

<div class="panel panel-default">
    <div class="panel-heading">
        Mortgage Lender Details
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-lg-12">

                <h2>{{@$agent->first_name}} {{@$agent->last_name}}</h2>
                <div class="row">
                    @if(!empty($agent->profile->photo))
                    <div class="col-lg-2"><img style="border-radius: 5px;" src='{{url($agent->profile->photo)}}' height="150" width="150"></div>
                    @endif
                    <div class="col-lg-12">
                        <p></p>
                        <p><strong>User Name :</strong> {{@$agent->username}}</p>
                        <p><strong>Email :</strong> {{@$agent->email}}</p>
                        <p><strong>Phone Number :</strong> {{@$agent->phone_number}}</p>
                        <p><strong>Address :</strong> {{@$agent->address_line1}} {{@$agent->address_line2}}</p>
                        <p><strong>Agent :</strong> {{@$agent->profile->agent_id}}</p>

                    </div>

                </div>

            </div>
        </div>

    </div>
    <!-- /.panel-body -->
</div>
@stop