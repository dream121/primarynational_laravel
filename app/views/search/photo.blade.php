@extends('layouts.default')
@section('assets-js')
@parent
<?php echo HTML::script('assets/js/search.js'); ?>
<script>
//    console.log(search_query);
    PNOBJ.Controller.showPhotoListing(search_query);
    $(document).ready(function(){
        var reduce_height = 200;
        $(window).resize(function() {
            $('.search_result').height($(window).height()-reduce_height );

        });
        $('.search_result').height($(window).height()-reduce_height );


        $("#sort_by").change(function(e){
            search_query.sort=$(this).val();
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });

        $("#min_price").change(function(e){
            search_query.min_price=$(this).val();
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });
        $("#max_price").change(function(e){
            search_query.max_price=$(this).val();
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });
        $(".beds").click(function(e){
            search_query.beds=$(this).val();
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });
        $(".baths").click(function(e){
            search_query.baths=$(this).val();
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });

        $(".types_option").click(function(e){
            search_query.types='';
            $(".types_option").each(function(){
                if($(this).is(':checked')){
                    if(search_query.types.length>0){
                        search_query.types+=','+$(this).val();
                    }
                    else{
                        search_query.types=$(this).val();
                    }
                }
            });
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
        });


        $("#btn-more-result").click(function(e){
            e.preventDefault();
            search_query.features='';
            $('.more *').filter(':input').each(function(){
                if($(this).attr('type')=='checkbox'){
                    if($(this).is(':checked')){
                        if(search_query.features.length>0){
                            search_query.features+=','+$(this).val();
                        }else{
                            search_query.features=$(this).val();
                        }
                    }
//                        search_query.features.push($(this).val());
                }else{
                    if($(this).val().length>0)
                      search_query[$(this).attr('name')]=$(this).val();
                }
            });
            console.log(search_query);
            PNOBJ.Controller.showPhotoListing(search_query);
            keep_history(search_query);
            $('.more_options').show();
            $(".more").slideToggle(1);

        });
    })
</script>
@stop
@section('content')

<div class="col-lg-3 search_result  fixed_search_result">
    <div>
        <h5>SEARCH RESULTS</h5>
        <hr>
        <div class="side_bar_listing">
            <!-- Need to load to search result as listing.. -->
            <p class="text-center">Loading...</p>
        </div>
    </div>
</div>
<div class="container-fluid margin_top_after_sub_menu">
    <div class="row">
        <div class="col-lg-9 col-lg-offset-3 search_details_content">
            <!-- need to load search result in photo view format -->
            <p class="text-center">Loading...</p>
        </div>
    </div>
</div>
<script id="template-small-list" type="text/x-handlebars-template">
    @{{#each data }}
    <div>
        <a href="#@{{listing_id}}" class="goto" data-target="go-@{{listing_id}}">
            <div class="thumbnail">
                @{{#if photo_available}}
                <img class="lazy img-responsive" src="http://placehold.it/921x537/e6e6e6/ffb1b6&text=Loading..."  data-original="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg" alt="@{{listing_id}}"/>
                @{{else}}
                <img class="img-responsive" src="@{{main_photo}}" alt="Thumb img for @{{street_number}} @{{street_name}}, @{{city}}"  />
                @{{/if}}
                
                <div class="caption clearfix search_result_content">
                    <div class="caption_addr">
                        <p>@{{unparsed_address}}</p>
                        <p>@{{bedrooms}} Beds, @{{full_baths}} Baths</p>
                    </div>

                    <div class="caption_price">
                        <p><strong>@{{formatedPrice}}</strong></p>
                        <p><img src="@{{mls_logo}}" alt="@{{listing_id}}"></p>
                    </div>
                </div>
            </div>
        </a>
    </div>
    @{{/each}}
    <div class="clearfix"></div>
</script>
<script id="template-details-list" type="text/x-handlebars-template">

    <div class="sub_header clearfix">
        <section id="search-filter">
            @{{#if total}}
                <h2 class="pull-left"> @{{numberWithComma from}} To @{{numberWithComma to}} of @{{numberWithComma total}} Properties for sale</h2>
             @{{else}}
                <h2 class="pull-left"> No Property Match</h2>
             @{{/if}}
            <div class="pull-right">
                <button class="btn btn-danger btn-lg border_radius_none display_block" data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}">
                    <span class="glyphicon glyphicon-th-list"></span> Setup Searches &amp; listing Alerts
                </button>
                <span class="color_light display_block text-right margin_top_5">Updated {{@($update_interval->days * 24 * 60)+($update_interval->h *60)+ $update_interval->i}} minutes ago</span>
            </div>
        </section>
    </div>
    @{{#each data }}
    <div class="search_details clearfix" id="go-@{{listing_id}}">
        <div class="search_btn_group">
            <div class="btn-group">
                @{{#if favorite}}
                    <button type="button" class="btn btn-default favorites fav" data-id="@{{listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="@{{favorite}}">
                    <span class="glyphicon glyphicon-star"></span> <span class="fav-text">FAVORITES</span>
                    </button>
                 @{{else}}
                     <button type="button" class="btn btn-default favorites" data-id="@{{listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="@{{favorite}}">
                     <span class="glyphicon glyphicon-star"></span> <span class="fav-text">ADD TO FAVORITES</span>
                     </button>
                 @{{/if}}

                </button>
                <button type="button"  class="btn btn-default listing_alert" data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}">
                    <span class="glyphicon glyphicon-bell"></span>GET LISTING ALERTS
                </button>
                <button type="button" class="btn btn-default thumbs_up">
                    <span class="glyphicon glyphicon-thumbs-up"></span>
                </button>
            </div>
        </div>
        <div class="col-lg-6">
            <div class="search_details_tab">
                <ul class="nav nav-tabs">
                    <li class="active"><a href="#Photos-@{{listing_id}}" data-toggle="tab"><span
                        class="glyphicon glyphicon-picture"></span>
                        Photos</a></li>
                        <li><a href="#Map-@{{listing_id}}" data-id="@{{listing_id}}" class="photo-map" data-toggle="tab" data-lat=@{{latitude}}
                           data-lng=@{{longitude}}><span class="glyphicon glyphicon-map-marker"></span> Quick Map</a></li>
                           <li><a href="#Local-@{{listing_id}}" data-toggle="tab"><span class="glyphicon glyphicon-camera"></span>
                            Local pics</a></li>
                        </ul>

                        <!-- Tab panes -->
                        <div class="tab-content">
                            <div class="tab-pane active" id="Photos-@{{listing_id}}">
                                <div class="photos_slider">
                                    @{{#if photo_available}}
                                    @{{#if status_icon}}
                                    	<div class="new_tag">
                                        	<img src="@{{status_icon}}" alt="@{{status}}"/>
                                    	</div>
                                    @{{/if}}
                                    <div class="flexslider slider-@{{listing_id}}">
                                        <ul class="slides">
                                            @{{#each photos}}
                                            <li data-thumb="@{{this}}">
                                                <img class="lazy" src="http://placehold.it/921x537/e6e6e6/ffb1b6&text=Loading..." data-src="@{{this}}" />
                                            </li>
                                            @{{/each}}
                                        </ul>
                                    </div>
                                    <div class="flexslider carousel-img carousel-@{{listing_id}}">
                                        <ul class="slides">
                                            @{{#each photos}}
                                            <li data-thumb="@{{this}}">
                                                <img src="@{{this}}" />
                                            </li>
                                            @{{/each}}
                                        </ul>
                                    </div>
                                    @{{else}}
                                        <img class="img-responsive" src="@{{main_photo}}" alt="Thumb img for @{{street_number}} @{{street_name}}, @{{city}}"  />
                                    @{{/if}}
                                </div>
                            </div>
                            <div class="tab-pane" id="Map-@{{listing_id}}">
                                <div id="map-canvas-@{{listing_id}}" class="map-canvas"></div>
                            </div>
                            <div class="tab-pane" id="Local-@{{listing_id}}">...</div>

                        </div>
                    </div>
                </div>

                <div class="col-lg-6">
                    <div class="product_details">
                        <h4>@{{unparsed_address}}<br> 
                        @{{city}}, @{{state}} @{{zip_code}}</h4>

                            <div class="sample_details clearfix">
                                <ul class="list-inline list-unstyled">
                                    <li>
                                        <strong>@{{bedrooms}}</strong>
                                        <span>BEDS</span>
                                    </li>
                                    <li>
                                        <strong>@{{full_baths}}</strong>
                                        <span>BATH</span>
                                    </li>
                                    <li>
                                        <strong>@{{half_baths}}</strong>
                                        <span>1/2 BATHS</span>
                                    </li>
                                    <li>
                                        <strong>@{{acre}}</strong>
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
                                        <strong>@{{year_built}}</strong>
                                        <span>BUILT</span>
                                    </li>
                                    <li>
                                        <strong><span class="glyphicon glyphicon-home"></span></strong>
                                        <p>@{{property_type}}</p>
                                    </li>
                                </ul>
                            </div>

                            <div class="price_n_details clearfix">
                                <h2><strong>@{{formatedPrice}}
                                    <a href="@{{url}}" class="btn btn-danger btn-lg pull-right show_details_listing" data-id="@{{listing_id}}" data-lng="@{{longitude}}" data-lat="@{{latitude}}" data-address="@{{full_address}}">VIEW FULL DETAILS</a>
                                </strong></h2>
                                <p><strong>Neighborhood:</strong> <br>
                                    @{{neighborhood}}</p>
                                </div>
                                <div class="courtesy clearfix">
                                    <div class="pull-left"> {{@isset($agent->Profile->office_name)?'Listing provided courtesy of '.$agent->Profile->office_name:''}}

                                    </div>
                                    <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="request_showing clearfix">
                                <img class="pull-left" src="{{asset('assets')}}/img/request_showing_icon.png"/>
                                <button class="btn btn-danger btn-lg pull-right request_a_showing_btn" data-toggle="modal" data-id="@{{listing_id}}" data-address="@{{full_address}}" data-target="#request_a_showing">REQUEST SHOWING</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <ul class="list-unstyled search_details_btm_nav">
                                <li><a href="" data-toggle="modal" class="inquiry" data-id="@{{listing_id}}" data-target="#ask_an_agent"><span class="glyphicon glyphicon-volume-up"></span> Inquire/Ask Question</a></li>
                                @{{#if favorite}}
                                <li><a href="" class=" favorites fav" data-id="@{{listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="@{{favorite}}"><span class="glyphicon glyphicon-star"></span> <span class="fav-text">Favorite</span></a></li>
                                @{{else}}
                                <li><a href="" class=" favorites" data-id="@{{listing_id}}" data-is_signed_in="{{@Auth::check()?'true':'false'}}" data-fav="@{{favorite}}"><span class="glyphicon glyphicon-star"></span> <span class="fav-text">Add to Favorites</span></a></li>
                                @{{/if}}
                                <li ><a href="#"  data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}"><span class="glyphicon glyphicon-bell"></span> GET LISTING ALERTS</a></li>
                                <li><a href="" onclick="$('a[href=#Map-@{{listing_id}}]').tab('show'); return false;"><span class="glyphicon glyphicon-map-marker"></span> Show on Map</a></li>
                                <li><a href="@{{url}}" class="show_details_listing" data-id="@{{listing_id}}" data-lng="@{{longitude}}" data-lat="@{{latitude}}" data-address="@{{full_address}}"><span class="glyphicon glyphicon-circle-arrow-right"></span> More Details</a></li>
                            </ul>
                        </div>
                    </div>

                    @{{#unless @index}}
                    <div class="row ad-common">
                        <div class="col-md-12">
                            <div class="find_home clearfix">
                                <div class="col-md-4">
                                    <img src="{{asset('assets')}}/img/find_home_photo.png"/>

                                    <h3>Watch this video</h3>
                                </div>
                                <div class="col-md-8">
                                    <h2>Found A home You like...?</h2>

                                    <p>Our <strong><em>AGENTS</em></strong> make it <br>
                                        easy to see the homes you like
                                    </p>
                                    <span>
                                        Call us at 123-456-798
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>
                    @{{/unless}}
                    @{{/each}}
                    <div class="clearfix"></div>
                    <div class="row">
                    <div class="col-lg-2">
                        <ul class="pager">
                             @{{#if prv_page_link}}
                                <li class="pull-left " style="padding-left: 5px;"><a id="btnprv" href="http://@{{prv_page_link}}">Previous</a></li>
                             @{{/if}}
                        </ul>
                    </div>
                        <div class="col-lg-8">
                        @{{#if total}}
                            <h4 class="pager" style="color: #bd1f31"> Viewing: @{{numberWithComma from}} To @{{numberWithComma to}} of @{{numberWithComma total}}</h4>
                        @{{/if }}
                        </div>
                        <div class="col-lg-2">
                            <ul class="pager">
                                @{{#if next_page_link}}
                                <li class="pull-right " style="padding-left: 5px;"><a id="btnxt" href="http://@{{next_page_link}}">Next</a></li>
                                 @{{/if}}
                            </ul>
                        </div>
                    </div>
                </script>
                @stop

