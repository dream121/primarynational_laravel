
<div class="modal-listing-header navbar-fixed-top">
	<button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">x</span><span class="sr-only">Close</span></button>
	<div class="previous_item">
		<a href="#"><span class="glyphicon glyphicon-chevron-left"></span></a>
	</div>
	<div class="header_content">
		<div class="header_photo">
			<img class="lazy img-responsive" src="{{$property->main_photo}}" alt="Thumb img for {{$property->full_address}}" >
		</div>
		<h3>{{$property->full_address}}</h3>
		<div class="product_details_full">
			<ul class="list-inline">
				<li>PRICE: <span class="color-red"><strong>${{number_format($property->list_price)}}</strong></span></li>
				<li>STATUS: <strong>{{$property->status}}</strong></li>
				<li>ON SITE: <strong>TODAY</strong></li>
				<li>UPDATED: <strong>{{@($update_interval->days * 24 * 60)+($update_interval->h *60)+ $update_interval->i}} MIN AGO</strong></li>
				<li>MLS#: <strong>{{$property->listing_id}}</strong></li>
			</ul>
		</div>
		<div class="search_btn_group">
			<div class="btn-group">
			@if($property->favorite)
				<button type="button" class="btn btn-default favorites fav" data-id="{{$property->listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="{{@$property->favorite}}">
					<span class="glyphicon glyphicon-star"></span> <br>
					FAVORITES
				</button>
			@else
				<button type="button" class="btn btn-default favorites" data-id="{{$property->listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="{{@$property->favorite}}">
					<span class="glyphicon glyphicon-star"></span> <br>
					FAVORITES
				</button>

			@endif
				<button type="button" class="btn btn-default" data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}">
					<span class="glyphicon glyphicon-bell"></span> <br>
					ALARTS
				</button>
				<button type="button" class="btn btn-default">
					<span class="glyphicon glyphicon-thumbs-up"></span>   <br>
					LIKE
				</button>
				<div class="btn-group">
					<button type="button" class="btn btn-default dropdown-toggle" data-toggle="dropdown">
						<span class="glyphicon glyphicon-plus"></span> <br/>
						MORE
						<span class="caret"></span>
					</button>
					<ul class="dropdown-menu dropdown-menu-right" role="menu">
						<li><a href="#request_a_showing_" onclick="$('#view_full_details').scrollTo('.full_details_request_showing', 1000, {offset: -100});">Request a Showing</a></li>
						<li><a href="#ask_agent" onclick="$('#view_full_details').scrollTo('.ask_agent', 1000, {offset: -100});">Ask an Agent</a></li>
					</ul>
				</div>
			</div>
		</div>
	</div>
	<div class="next_item">
		<a href="#"><span class="glyphicon glyphicon-chevron-right"></span></a>
	</div>
</div>
<div class="modal-dialog modal-lg">
	<div class="modal-content">
		<div class="modal-body">
			<div class="bg_white">
				<div class="search_details margin_0 clearfix">
					<div class="col-lg-6">
						<div class="search_details_tab">
							<ul class="nav nav-tabs">
								<li class="active">
									<a href="#Photos" data-toggle="tab"><span class="glyphicon glyphicon-picture"></span>Photos</a>
								</li>
								<li><a href="#Map" data-toggle="tab" class="photo-map" data-id="{{$property->listing_id}}" data-toggle="tab" data-lat={{$property->latitude}} data-lng={{$property->longitude}}><span class="glyphicon glyphicon-map-marker"></span> Quick Map</a></li>
								<li><a href="#Local" data-toggle="tab"><span class="glyphicon glyphicon-camera"></span> Local pics</a></li>
							</ul>
							<!-- Tab panes -->
							<div class="tab-content">
								<div class="tab-pane active" id="Photos">
									<div class="photos_slider">
										@if($property->status=='New')
										<div class="new_tag">
											<img src="{{asset('assets')}}/img/new_tag.png" alt="New Listing" >
										</div>
										@endif
										@if($property->photos)
										<div class="flexslider slider-single-listing">
											<ul class="slides">
												@foreach($property->photos as $photo)
												<li>
													<img src="{{$photo}}" alt="{{$photo}}"  >
												</li>
												@endforeach
											</ul>
										</div>
										<div class="flexslider carousel-img carousel-single-listing">
											<ul class="slides">
												@foreach($property->photos as $photo)
												<li >
													<img src="{{$photo}}" alt="{{$photo}}" >
												</li>
												@endforeach
											</ul>
										</div>
										@else
											<img class="img-responsive" src="{{$property->main_photo}}" alt="Thumb img for {{$property->full_address}}"  />
										@endif
									</div>
								</div>
								<div class="tab-pane" id="Map"><div id="map-canvas-details" class="map-canvas"></div></div>
								<div class="tab-pane" id="Local">...</div>
							</div>
						</div>
					</div>
					<div class="col-lg-6">
						<div class="margin_top_20">
							<div class="product_details">
								<div class="sample_details clearfix">
									<ul class="list-inline list-unstyled">
										<li>
											<strong>{{$property->bedrooms}}</strong>
											<span>BEDS</span>
										</li>
										<li>
											<strong>{{$property->full_baths}}</strong>
											<span>BATH</span>
										</li>
										<li>
											<strong>{{$property->half_baths}}</strong>
											<span>1/2 BATHS</span>
										</li>
										<li>
											<strong>{{$property->acre}}</strong>
											<span>ACRES</span>
										</li>
									</ul>
									<ul class="list-inline list-unstyled product_border_btm">
										<li>
											<strong>1700</strong>
											<span>SQFT</span>
										</li>
										<li>
											<strong>$21</strong>
											<span>$/SQFT</span>
										</li>
										<li>
											<strong>{{$property->year_built}}</strong>
											<span>BUILT</span>
										</li>
										<li>
											<strong><span class="glyphicon glyphicon-home"></span></strong>
											<p>{{$property->property_type}}</p>
										</li>
									</ul>
								</div>
								<div class="full_details_price clearfix">
									<h2><strong>${{number_format($property->list_price)}}
										@if($property->property_type=='Rental')
										<button class="normal_mo pull-right">$1,281/mo</button>
										@endif
									</strong>
								</h2>
								<div class="free_rate_quote clearfix">
									<a class="pull-left" href="{{url('/finance')}}">Get a Free Rate quote</a>
									{{--<a class="pull-right" href="#">Payment Calculator</a>--}}
								</div>
								<div class="full_details_location">
									<div class="col-md-8">NEIGHBORHOOD:</div>
									<div class="col-md-4 color-red">{{$property->neighborhood}}</div>
									<div class="col-md-8">COUNTY:</div>
									<div class="col-md-4 color-red">{{$property->county}}</div>
									<div class="col-md-8">AREA:</div>
									<div class="col-md-4 color-red">{{@$property->area}}</div>
									<div class="col-md-8">ELEMENTARY SCHOOL:</div>
									<div class="col-md-4 color-red">{{@$property->elementary_school}}</div>
									<div class="col-md-8">MIDDLE SCHOOL:</div>
									<div class="col-md-4 color-red">{{@$property->middle_school}}</div>
									<div class="col-md-8">HIGH SCHOOL:</div>
									<div class="col-md-4 color-red">{{@$property->high_school}}</div>
									<div class="col-md-8">SCHOOL DISTRICT:</div>
									<div class="col-md-4 color-red">SCOTT COUNTY</div>
								</div>
							</div>
						</div>
					</div>
					</div>
				</div>
				<div class="full_details_request_showing border bg_white">
					<div class="col-md-3">
						<div class="img_frame_2 border img-box">
							<img src="{{@isset($agent->Profile->photo)?@Croppa::url($agent->Profile->photo, 215, 254, array('resize')):''}}" alt="Agent Picture"/>
						</div>
						<div><h4 class="text-center">{{@$agent->first_name}} {{@$agent->last_name}}</h4></div>
					</div>
					<div class="col-md-7 col-md-offset-1">
						<h2>Request a Showing</h2>
						<h4>For <i>{{$property->full_address}}</i></h4>
						<div id="message"></div>
						<form role="form" id="request_showing_ajax_form">
							<input type="hidden" name="listing_id" value="{{$property->listing_id}}">
							<input type="hidden" name="address" value="{{$property->full_address}}">
							<div class="col-md-4">
								<div class="form-group">
									<input id="email" type="email" name="email" required class="form-control" value="{{@Auth::user()->email}}" placeholder="Email">
								</div>
							</div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="phone_number"  required class="form-control" value="{{@Auth::user()->phone_number}}" placeholder="Phone Number">
								</div>
							</div>
							<div class="clearfix"></div>
							<div class="col-md-4">
								<div class="form-group">
									<input type="text" name="date"  class="form-control datepicker" data-provide="datepicker" value="{{date('m/d/Y')}}" placeholder="Date">
								</div>
							</div>
							<div class="col-md-4">
								<select name="time" class="form-control">
									<option selected="selected" value="Anytime">Anytime</option>
									<option value="Morning">Morning</option>
									<option value="Afternoon">Afternoon</option>
									<option value="Evening">Evening</option>
								</select>
							</div>
							<button class="btn btn-danger request_an_agent" type="submit">
								LET'S GO SEE IT!
							</button>
						</form>
					</div>
				</div>
				<div class="full_fav border bg_white no-print">
					<div class="col-md-3">
					@if($property->favorite)
						<a href="#"  class="favorites fav" data-id="{{$property->listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="{{@$property->favorite}}">
							<span class="glyphicon glyphicon-thumbs-up color-red"></span>
							<h3 class="color-red">Save as favorite</h3>
							<p>and access it later</p>
						</a>
					@else
						<a href="#"  class="favorites" data-id="{{$property->listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="{{@$property->favorite}}">
							<span class="glyphicon glyphicon-thumbs-up"></span>
							<h3 class="">Save as favorite</h3>
							<p>and access it later</p>
						</a>
					@endif

					</div>
					<div class="col-md-3">
						<a href="#print" onclick="$('#view_full_details .search_details').print()">
							<span class="glyphicon glyphicon-print"></span>
							<h3>Print flyer</h3>
							<p>and take it with you</p>
						</a>
					</div>
					<div class="col-md-3">
						<a href="#direction_hash_" onclick="$('#view_full_details').scrollTo('#direction_hash', 1000, {offset: -100});">
							<span class="glyphicon glyphicon-thumbs-up"></span>
							<h3>Get Direction</h3>
							<p>to go see it</p>
						</a>
					</div>
					<div class="col-md-3">
						<a href="#">
							<span class="glyphicon glyphicon-envelope"></span>
							<h3>Email List</h3>
							<p>Share with your friends</p>
						</a>
					</div>
				</div>
				<div class="property_feature border">
					<div class="property_wrapper  border">
						<div class="property_header ">
							<h4>Property description</h4>
						</div>
						<div class="property_details border">
							<p>
								{{@$property->remarks}}
							</p>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="property_wrapper  border">
						<div class="property_header">
							<h4>Property Feature</h4>
						</div>
						<div class="property_details border">
							<div class="col-md-4">
								<h3>EXTORIOR</h3>
								<ul class="list-unstyled">
									<li>Construction</li>
									<li>
										<ul>
											<li>{{$property->construction?:'N/A'}}</li>
										</ul>
									</li>

								</ul>
								<ul class="list-unstyled">
									<li>Exterior Features</li>
									<li>
										<ul>
											@if($property->exterior)
											<?php $ext_array = explode(',',$property->exterior); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>N/A</li>
											@endif
										</ul>
									</li>

								</ul>

								<ul class="list-unstyled">
									<li>Foundation</li>
									<li>
										<ul>
											@if($property->foundation)
											<?php $ext_array = explode(',',$property->foundation); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>N/A</li>
											@endif
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Garage</li>
									<li>
										<ul>
											<li>{{$property->garage_spaces?'Yes':'No'}}</li>
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Garage Carport Type</li>
									<li>
										<ul>
											<li>{{$property->garage_desc?:'N/A'}}</li>
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Location Description</li>
									<li>
										<ul>
											<li>{{$property->near?:'N/A'}}</li>
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Style</li>
									<li>
										<ul>
											@if($property->style)
											<?php $ext_array = explode(',',$property->style); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>N/A</li>
											@endif
										</ul>
									</li>
								</ul>
							</div>
							<div class="col-md-4">
								<h3>INTERIOR</h3>
								<ul class="list-unstyled">
									<li>Appliances</li>
									<li>
										<ul>
											@if($property->appliances)
											<?php $ext_array = explode(',',$property->appliances); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>N/A</li>
											@endif
										</ul>
									</li>

								</ul>

								<ul class="list-unstyled">
									<li>Basement</li>
									<li>
										<ul>
											@if($property->basement_rooms_type)
											<?php $ext_array = explode(',',$property->basement_rooms_type); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Fireplace</li>
									<li>
										<ul>
											@if($property->fireplace)
											<?php $ext_array = explode(',',$property->fireplace); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Heating</li>
									<li>
										<ul>
											@if($property->heat_system)
											<?php $ext_array = explode(',',$property->heat_system); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>
								</ul>

								<ul class="list-unstyled">
									<li>Interior Feature</li>
									<li>
										<ul>
											@if($property->interior)
											<?php $ext_array = explode(',',$property->interior); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>
								</ul>
							</div>
							<div class="col-md-4">

								<h3>PROPERTY</h3>
								<ul class="list-unstyled">
									<li>Amenity Fee</li>
									<li>
										<ul>
											@if($property->amenities)
											<?php $ext_array = explode(',',$property->amenities); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>

								</ul>
								<ul class="list-unstyled">
									<li>Sewer</li>
									<li>
										<ul>
											@if($property->sewer)
											<?php $ext_array = explode(',',$property->sewer); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>

								</ul>

								<ul class="list-unstyled">
									<li>Water</li>
									<li>
										<ul>
											@if($property->water_supply)
											<?php $ext_array = explode(',',$property->water_supply); ?>
											@foreach($ext_array as $ext)
											<li>{{$ext}}</li>
											@endforeach
											@else
											<li>None</li>
											@endif
										</ul>
									</li>
								</ul>
							</div>
						</div>
						<div class="clearfix"></div>
					</div>
					<div class="clearfix"></div>
				</div>
				<div class="mls_list border">
					<div class="row">
						<div class="col-md-3">
							{{ HTML::image($property->mls_logo, $property->mls_logo , $attributes = array()) }}
						</div>
						<div class="col-md-9">
							<p>Listing provided courtesy of {{$property->listing_agent_first_name}} {{$property->listing_agent_last_name}}  of {{$property->listing_office_name}}.
								Listing information © 2014 {{$property->mls_system_id}} Multiple Listing Service. All rights reserved.
							</p>
						</div>
					</div>
				</div>
				<div class="you_may_like border">
					<h3>You may also like:</h3>
					<div class="row">
						
						@foreach($property->like_to_see as $lts_property)
						<a href="#" data-listingid="{{$lts_property->listing_id}}">
							<div class="col-lg-4 col-md-4 property">
								<div class="listing">
									@if($lts_property->status == 'New')
									<div class="new_tag_2">
										<img src="{{asset('assets')}}/img/new_tag.png" alt="New"/>
									</div>
									@endif
									<div class="star_tag">
										<button type="button" class="btn btn-default btn-lg">
											<span class="glyphicon glyphicon-star"></span>
										</button>
									</div>
									<div class="listing_img">
										<img class="img-responsive" src="http://images.primarynational.com/{{$lts_property->mls_system_id}}/{{$lts_property->listing_key}}_1.jpg" alt="{{$lts_property->listing_id}}"/>
									</div>
									<div class="listing_content">
										<div class="content_top clearfix">
											<h5 class="pull-left"><b>{{$lts_property->full_address}}</b></h5>
											<span class="pull-right margin-top-10">${{number_format($lts_property->list_price)}}</span>
										</div>
										<p>{{$lts_property->property_type}} <img class="pull-right" src="{{$lts_property->mls_logo}}" alt=""></p>

										<div class="clearfix"></div>
										<div class="see_details clearfix">
											<span class="pull-right">{{$lts_property->bedrooms}} BEDS  {{$lts_property->full_baths}} BATHS  10 ACRES</span>
										</div>
									</div>
								</div>
							</div>
						</a>
						@endforeach
					</div>
				</div>
				<div class="details_map">
					<!-- Map functionality -->
					<div class="details_map" id="show_map"> </div>
				</div>
				<div class="distance border" id="direction_hash">
					<h2 class="color-red">Distance & Driving Directions</h2>
					<h4>We'll help you here...</h4>

					<div class="col-md-5">
						<input class="form-control" name="direction-from" id="direction-from" data-toggle="tooltip" data-placement="bottom" title="Enter your starting address" placeholder="FROM:">
					</div>
					<div class="col-md-5">
						<input class="form-control" name="direction-to" id="direction-to" data-toggle="tooltip" data-placement="bottom" title="Enter your destination address" placeholder="TO:" value="{{$property->full_address}}">

					</div>
					<button class="btn btn-danger" id="get_dir_distance">
						GO
					</button>

					<div id="direction_panel" class="text-left"></div>
				</div>
				{{--<div class="neighborhood_snaps border">--}}
					{{--<h3>Neighborhood snaps</h3>--}}
					{{--<div class="row">--}}
						{{--<div class="col-md-3">--}}
							{{--<img src="img/neighborhood.jpg" alt=""/>--}}
						{{--</div>--}}
					{{--</div>--}}
				{{--</div>--}}
				<div class="ask_agent border">
					<h2 class="color-red">Ask an Agent</h2>
					<h4>About <i>{{$property->full_address}}</i></h4>
					<form class="form-horizontal" role="form" id="ask_an_agent_details_form">
						<input type="hidden"  name="listing_id" value="{{$property->listing_id}}">
						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" required id="first_name" name="first_name" class="form-control"  placeholder="First Name">
							</div>
							<div class="col-sm-6">
								<input type="text" required id="last_name" name="last_name" class="form-control"  placeholder="Last Name">
							</div>
						</div>
						<div class="form-group">
							<div class="col-sm-6">
								<input type="text" required id="email" name="email" class="form-control"  placeholder="EMAIL ID">
							</div>
							<div class="col-sm-6">
								<input type="text" id="phone_number" name="phone_number" class="form-control"  placeholder="Phone Number">
							</div>
						</div>
						<div>
							<textarea  id="comments"  name="comments" class="form-control" cols="30" rows="10">What would you like to know?</textarea>
						</div>
						<div class="form-group">
							<div class="col-sm-2 pull-right">
								<button id="btn-ask" class=" btn btn-danger pull-right">SEND OUT YOUR QUESTON</button>
							</div>
						</div>
					</form>
				</div>
				<div class="details_footer clearfix">
					<div class="photo_address clearfix">
						<div class="col-md-3">
							<div class="img_frame" style="max-width: 300px;">
								<div class="shadow_left"></div>
								<div class="shadow_right"></div>
								<div class="img_holder">
									<div class="agents_img">
										<img class="img-responsive" src="<?=Croppa::url($agent->Profile->photo, 215, 254, array('resize'))?>" alt="" >
									</div>
								</div>
							</div>
						</div>
						<div class="col-md-7 col-md-offset-2">
							<div class="details_footer_address">
								<h2 class="color-red">{{ $agent->first_name }} {{$agent->last_name}}</h2>
								<h4>{{@$agent->Profile->designation}}</h4>
								<p>Cell: {{$agent->phone_number}}</p>
								<p class="width_60">{{@$agent->Profile->office_name}}<br>{{@$agent->Profile->office_address_line1}} {{@$agent->Profile->office_address_line2}}

								</p>
							</div>
						</div>
					</div>
					<div class="details_footer_mls">
						<div class="col-md-1">
							<img src="{{$property->mls_logo}}" alt="MLS Logo" >
						</div>
						<div class="col-md-11">
							<p>The data relating to real estate for sale on this web site comes in part from the Internet Data Exchange Program of the Lexington-Bluegrass Association of Realtors Multiple Listing Service. Real estate listings held by IDX Brokerage firms other than Cypress Residential Group are marked with the IDX logo and detailed information about them includes the name of the listing IDX Brokers. Information is deemed reliable but is not guaranteed accurate by the MLS or listing broker.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>