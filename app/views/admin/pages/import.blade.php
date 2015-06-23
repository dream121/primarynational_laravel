@extends('layouts.default')

@section('content')
<div class="panel panel-default">
	<div class="panel-heading">
		Import Data from Excel file to database 
	</div>
	<div class="panel-body">
		<div class="row">
			<div class="col-lg-12">
				{{ Form::open(array('role'=>"form",'files' => true)) }}
				<div class="form-group">
					{{ Form::label('Choose file: ') }}
					{{ Form::file('exel_file')}}
					{{ $errors->first('exel_file','<p class="text-red">:message</p>'); }}

				</div>

				<div class="form-group">
					{{ Form::submit('Upload',array('class'=>'btn btn-primary')); }}
				</div>
				{{ Form::close() }}

				<br>
				<h3>Uploaded files</h3>
				<hr>
				<ul>
					@foreach($files as $file)
					<li>
						{{ $file}}
						<a href="{{ url('admin/wars/deletefile', $file) }}" onclick="if(!confirm('Are you sure to delete this item?')){return false;};" title="Delete this Item"><i class="glyphicon glyphicon-trash"></i> </a>
					</li>
					@endforeach
				</ul>
				

			</div>
		</div>

	</div>
	<!-- /.row (nested) -->
</div>
@stop