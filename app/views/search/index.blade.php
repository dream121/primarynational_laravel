@extends('layouts.default')
@section('assets-js')
@parent
{{ HTML::style('assets/css/flexslider.css') }}
<?php echo HTML::script('assets/js/handlebars.min.js'); ?>
<?php echo HTML::script('assets/js/jquery.scrollTo.min.js'); ?>
<?php echo HTML::script('assets/js/accounting.min.js'); ?>
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
<?php echo HTML::script('assets/js/masonry.pkgd.min.js'); ?>
<?php echo HTML::script('assets/js/jquery.flexslider-min.js'); ?>
<?php echo HTML::script('assets/js/app.js'); ?>
<?php echo HTML::script('assets/js/search.js'); ?>

<script>

        
    $(document).ready(function(){
        alert("test");
        var reduce_height = 200;
        $(window).resize(function() {
            $('.search_result').height($(window).height()-reduce_height );
        });
        $('.search_result').height($(window).height()-reduce_height );
        
        var nav_bar_height = $('.navbar-fixed-top').height();
        $('.search_result').css('top',nav_bar_height);
        // alert()
         console.log(search_query);
        // console.log($('.search_result').height($(window).height()-reduce_height ));
        PNOBJ.Controller.showPhotoListing(search_query);
    })

</script>
@stop
@section('content')

<div class="col-lg-3 search_result fixed_search_result">
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
                <img class="lazy img-responsive" src="http://placehold.it/921x537/efefef/111&text=Loading..."  data-original="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg"
                alt="@{{listing_id}}"/>

                <div class="caption clearfix search_result_content">
                    <p class="pull-left">
                        <strong>@{{formatedPrice}}</strong> <br>
                        @{{unparsed_address}} <br>
                        @{{bedrooms}} Beds, @{{full_baths}} Baths
                    </p>
                    <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"/>
                </div>
            </div>
        </a>
    </div>
    @{{/each}}
    <div class="clearfix"></div>
</script>
<script id="template-details-list" type="text/x-handlebars-template">
    @{{#each data }}
    <div class="search_details clearfix" id="go-@{{listing_id}}">
        <div class="search_btn_group">
            <div class="btn-group">
                <button type="button" class="btn btn-default">
                    <span class="glyphicon glyphicon-star"></span> ADD TO FAVORITES
                </button>
                <button type="button" class="btn btn-default"  data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}">
                    <span class="glyphicon glyphicon-bell"></span>GET LISTING ALERTS
                </button>
                <button type="button" class="btn btn-default">
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
                                    <div class="new_tag">
                                        <img src="{{asset('assets')}}/img/new_tag.png" alt=""/>
                                    </div>
                                    <div class="flexslider slider-@{{listing_id}}">
                                        <ul class="slides">
                                            @{{#each photos}}
                                            <li data-thumb="@{{this}}">
                                                <img class="lazy" src="http://placehold.it/921x537/bada55/111&text=Loading..." data-src="@{{this}}" />
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
                        <h4>@{{street_number}} @{{street_name}},<br> 
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
                                    <a href="@{{url}}" class="btn btn-danger pull-right">VIEW FULL DETAILS</a>
                                </strong></h2>
                                <p><strong>Neighborhood:</strong> <br>
                                    Treehaven</p>
                                </div>
                                <div class="courtesy clearfix">
                                    <div class="pull-left">Listing provided courtesy of Keller Williams
                                        Greater Lexington.

                                    </div>
                                    <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"/>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="request_showing clearfix">
                                <img class="pull-left" src="{{asset('assets')}}/img/request_showing_icon.png"/>
                                <button class="btn btn-danger btn-lg pull-right">REQUEST SHOWING</button>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <ul class="list-unstyled search_details_btm_nav">
                                <li><a href="#"><span class="glyphicon glyphicon-volume-up"></span> Inquire/Ask Question</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-star"></span> Add to Favorites</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-bell"></span> GET LISTING ALERTS</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-map-marker"></span> Show on Map</a></li>
                                <li><a href="#"><span class="glyphicon glyphicon-circle-arrow-right"></span> More Details</a></li>
                            </ul>
                        </div>
                    </div>

                    @{{#unless @index}}
                    <div class="row">
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
                </script>
                <script id="listing_details" type="x-tmpl-mustache">
                    <p>Details Page</p>
                    @{{property_type}}<br>
                    @{{remarks}}

                </script>
                @stop

