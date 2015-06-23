@extends('layouts.default')
@section('content')
<div class="container-fluid bg_white">
	<div class="width_90">
		<div class="header_container">
		    <h3><strong>{{@$page->title}}</strong></h3>
	    </div>
		<p>{{@$page->details}}</p>
	</div>	
</div>
@stop