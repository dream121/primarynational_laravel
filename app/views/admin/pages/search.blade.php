@extends('layouts.default')

@section('content')

<div class="panel panel-default">
    <div class="panel-heading">
        Search Result
    </div>
    <!-- /.panel-heading -->
    <div class="panel-body">
    Total record found : {{ $result->getTotal() }}
    <table class="table table-striped table-bordered table-hover">
        <thead>
            <tr>
                <th>War Name</th>
                <th>Entry Type</th>
                <th>Entry Type Description</th>
                <th>Entry Start Date</th>
                <th>Entry Stop date</th>
                <th class="text-center"> Action</th>
            </tr>
        </thead>
        <tbody>
        @foreach($result as $war)
        <tr>
           <td>{{ HTML::link('admin/wars/show/'.$war->id,$war->war_name) }}</td>
           <td>{{ $war->war_type }}</td>
           <td>{{ $war->war_type_description }}</td>
           <td class="text-center">{{ $war->war_start_date!=''&&$war->war_start_date!='0000-00-00 00:00:00'?date("d-m-Y",strtotime($war->war_start_date)):' -- ' }}</td>
           <td class="text-center">{{ $war->war_stop_date!=''&&$war->war_stop_date!='0000-00-00 00:00:00'?date("d-m-Y",strtotime($war->war_stop_date)):' -- ' }}</td>
           <td class="text-center">
               <!-- show the nerd (uses the show method found at GET /nerds/{id} -->
                <a class="btn btn-small btn-success" href="{{ URL::to('admin/wars/show/' . $war->id) }}">Show</a>

                <!-- edit this nerd (uses the edit method found at GET /nerds/{id}/edit -->
                <a class="btn btn-small btn-info" href="{{ URL::to('admin/wars/edit/'.$war->id) }}">Edit</a>
                
                <a href="{{ url('admin/wars/delete', $war->id) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i></a>
                <!-- {{ Form::open(array('url' => 'admin/wars/' . $war->id, 'class' => 'pull-right')) }}
                {{ Form::hidden('_method', 'DELETE') }}
                {{ Form::submit('Delete', array('class' => 'btn btn-warning')) }}
                {{ Form::close() }} -->

           </td>
        </tr>
        @endforeach

        </tbody>
    </table>
   
        </div>
    </div>
    {{$pages}}
@stop