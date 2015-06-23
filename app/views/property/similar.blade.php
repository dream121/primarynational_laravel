@if(!$properties->isEmpty())
@foreach($properties as $property)
<a href="{{url($property->url)}}" >
	<div class="thumbnail">
		@if($property->photos_count>0)
		<img src="http://images.primarynational.com/{{$property->mls_system_id}}/{{$property->listing_key}}_1.jpg" alt="{{$property->listing_id}}"/>
		@else
		<p>Image not Available</p>
		@endif
		<div class="caption clearfix search_result_content">
			<p>
				<strong>${{number_format($property->listing_id)}}</strong> <br>
				{{$property->street_number}} {{$property->street_name}}, {{$property->city}}, 
                            {{$property->county}}, {{$property->state}}, {{$property->zip_code}}  <br>
				{{$property->bedrooms}} Beds, {{$property->full_baths}} Baths
			</p>
			<img src="{{url('assets/img/'.$property->mls_system_id.'.jpg')}}" alt="{{$property->mls_system_id}}"/>
		</div>
	</div>
</a>
@endforeach
@else
<p class="text-center">No Similar Property Found</p>
@endif