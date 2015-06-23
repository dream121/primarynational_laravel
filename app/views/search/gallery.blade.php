@extends('layouts.default')
@section('assets-js')
@parent
{{ HTML::script('assets/js/imagesloaded.pkgd.min.js') }}
{{ HTML::script('assets/js/masonry.pkgd.min.js'); }}
{{ HTML::script('assets/js/search.js') }}
<script>
    $(document).ready(function () {
        
        var container = $('.grid');
        PNOBJ.Controller.showGalleryListing('load',search_query,container);

        var offset = 0;

        var completed_resutl = false;

        var max_search_result = 500;
        
        var timeout;

        var scrolling_height = $('.footer_next').height()+$('.footer').height()+$('.pre-footer').height()+400;

        $(window).scroll(function () {

            if ($(window).scrollTop() + $(window).height() > $(document).height() - scrolling_height) {

                if($(".gallery-loader").hasClass('completed')){
                    completed_resutl=true;
                }
                
                if(!completed_resutl){

                    var number_of_listing = find_total_blocks();

                    if (number_of_listing > 0 && number_of_listing < max_search_result) {

                        clearTimeout(timeout);

                        timeout = setTimeout(function () {
                            $('.gallery-loader').removeClass('hidden');
                            if(typeof search_query.page != 'undefined'){
                                search_query.page=parseInt(search_query.page)+1;
                            }else{
                                search_query.page=2;
                            }
                            PNOBJ.Controller.showGalleryListing('scroll',search_query,container);
                        }, 1000);

                    }
                    
                    // if search result in more then max search result then show a warning message
                    if(number_of_listing>max_search_result){
                        completed_resutl = true;
                        $(".gallery-loader").removeClass('hidden').text('Too many listings to display. Please refine your search');
                    }
                }

            }

        });

        function find_total_blocks() {
            return $('.grid').find(".property").length;
        }


        $("#sort_by").change(function(e){
            search_query.sort=$(this).val();
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
            keep_history(search_query);
        });

        $("#min_price").change(function(e){
            search_query.min_price=$(this).val();
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
            keep_history(search_query);
        });
        $("#max_price").change(function(e){
            search_query.max_price=$(this).val();
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
            keep_history(search_query);
        });
        $(".beds").click(function(e){
            search_query.beds=$(this).val();
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
            keep_history(search_query);
        });
        $(".baths").click(function(e){
            search_query.baths=$(this).val();
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
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
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
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
            PNOBJ.Controller.showGalleryListing('load',search_query,container);
            keep_history(search_query);
        });
    });
</script>
@stop

@section('content')

<div class="container-fluid margin_top_after_sub_menu">
    <div class="width_90">
        <div class="sub_header clearfix">
            <section id="search-filter">
            </section>
        </div>
        <div class="row">
            <div class="listing_container">
                <div class="grid">
                <p class="text-center">Loading....</p>
                </div>
                <div class="clearfix"></div>
                <div class="page-loader"></div>
                <div class="pager-gallery"></div>
                <div id="page-nav">
                    <a href="{{route('api.v1.search.index',$uri)}}"></a>
                </div>
            </div>
        </div>
    </div>
</div>


<script id="template-single-property-list" type="text/x-handlebars-template">
    @{{#if init_load }}
        @{{#each data }}
            <div class="col-lg-4 col-md-4 masonry property">
                <div class="listing">
                    @{{#if status_icon}}
                        <div class="new_tag_2">
                            <img src="@{{status_icon}}" alt="@{{status}}"/>
                        </div>
                    @{{/if}}
                    <div class="star_tag">
                        @{{#if favorite}}
                        <button type="button" class="btn btn-default btn-lg favorites fav"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="false">
                            <span class="glyphicon glyphicon-star"></span>
                        </button>
                        @{{else}}
                        <button type="button" class="btn btn-default btn-lg favorites"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="false">
                            <span class="glyphicon glyphicon-star"></span>
                        </button>
                        @{{/if}}

                    </div>
                    <div class="listing_img">
                        <img class="img-responsive" src="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg" alt="@{{listing_id}}"/>
                    </div>
                    <div class="listing_content">
                        <div class="content_top clearfix">
                            <h5 class="pull-left"><b>@{{street_number}} @{{street_name}} @{{city}}, @{{state}}, @{{zip_code}} </b></h5>
                            <span class="pull-right margin-top-10">@{{formatedPrice}}</span>
                        </div>
                        <p>@{{property_type}} <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"></p>

                        <div class="clearfix"></div>
                        <div class="see_details clearfix">
                            <a href="@{{url}}" data-id="@{{listing_id}}" class="btn btn-danger pull-left see_details_btn show_details_listing" data-lng="@{{longitude}}" data-lat="@{{latitude}}" data-address="@{{street_number}} @{{street_name}}, @{{city}}, @{{state}} @{{zip_code}}">See details</a>
                            <span class="pull-right">@{{bedrooms}} BEDS  @{{full_baths}} BATHS  @{{ acre }} ACRES</span>
                        </div>
                    </div>
                </div>
            </div>
            @{{#compare @index}}
            <div class="col-lg-4 col-md-4 masonry property">
                <div class="listing" style="min-height:365px;">
                    <p><img style="min-width:150px;" class="pull-left" src="{{@url('assets/img/RISRETS.jpg')}}">© 2015 State-Wide Multiple Listing Service. All rights reserved. The data relating to real estate for sale or lease on this web site comes in part from the Internet Data Exchange (IDX) program of the State-Wide MLS. Data last updated: 2015-01-07T07:38:48.793. Real estate listings held by brokerage firms other than Hill Harbor Group are marked with the MLS logo or an abbreviated logo and detailed information about them includes the name of the listing broker. Information is deemed reliable but is not guaranteed accurate by the MLS or Hill Harbor Group. IDX information is provided exclusively for consumers personal, non-commercial use and may not be used for any purpose other than to identify prospective properties consumers may be interested in purchasing.
                    </p>
                </div>
            </div>
            <div class="col-lg-4 col-md-4 masonry property">
                <div class="listing" style="min-height:365px;">
                    <div class="row ad-common">
                        <div class="col-md-12">
                            <div class="find_home_gallery clearfix">
                                <div class="col-md-12">
                                    <img src="http://primarynational.local/assets/img/find_home_photo.png">

                                    <h3>Watch this video</h3>
                                </div>

                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <div class="find_home_gallery ">
                                <h4>Found A home You like...?</h4>
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
            </div>
            @{{/compare }}
        @{{/each}}
    @{{else}}
        @{{#each data }}
            <div class="col-lg-4 col-md-4 masonry property">
                <div class="listing">
                    @{{#if status_icon}}
                    <div class="new_tag_2">
                        <img src="@{{status_icon}}" alt="@{{status}}"/>
                    </div>
                    @{{/if}}
                    <div class="star_tag">
                        @{{#if favorite}}
                        <button type="button" class="btn btn-default btn-lg favorites fav"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="false">
                            <span class="glyphicon glyphicon-star"></span>
                        </button>
                        @{{else}}
                        <button type="button" class="btn btn-default btn-lg favorites"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="false">
                            <span class="glyphicon glyphicon-star"></span>
                        </button>
                        @{{/if}}

                    </div>
                    <div class="listing_img">
                        <img class="img-responsive" src="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg" alt="@{{listing_id}}"/>
                    </div>
                    <div class="listing_content">
                        <div class="content_top clearfix">
                            <h5 class="pull-left"><b>@{{street_number}} @{{street_name}} @{{city}}, @{{state}}, @{{zip_code}} </b></h5>
                            <span class="pull-right margin-top-10">@{{formatedPrice}}</span>
                        </div>
                        <p>@{{property_type}} <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"></p>

                        <div class="clearfix"></div>
                        <div class="see_details clearfix">
                            <a href="@{{url}}" data-id="@{{listing_id}}" class="btn btn-danger pull-left see_details_btn show_details_listing" data-lng="@{{longitude}}" data-lat="@{{latitude}}" data-address="@{{street_number}} @{{street_name}}, @{{city}}, @{{state}} @{{zip_code}}">See details</a>
                            <span class="pull-right">@{{bedrooms}} BEDS  @{{full_baths}} BATHS  @{{ acre }} ACRES</span>
                        </div>
                    </div>
                </div>
            </div>
    @{{/each}}
    @{{/if}}
</script>
<script id="template-search-result-numbers" type="text/x-handlebars-template">
    <h2 class="pull-left"> Total @{{numberWithComma to}} of @{{numberWithComma total}} Properties for sale</h2>
    <div class="pull-right">
        <button class="btn btn-danger btn-lg border_radius_none display_block"  data-toggle="modal"  data-target="{{@Auth::check()?'#save_search':'#free_mls_reg'}}">
            <span class="glyphicon glyphicon-th-list"></span> Setup Searches & listing Alerts
        </button>
        <span class="color_light display_block text-right margin_top_5">Updated {{@($update_interval->days * 24 * 60)+($update_interval->h *60)+ $update_interval->i}} minutes ago</span>
    </div>
</script>
<script id="template-loader-gallery" type="text/x-handlebars-template">
        <div class="row ">
            <div class="col-lg-4 col-lg-offset-4">
            @{{#if success}}
                <button class="btn btn-danger btn-lg btn-block border_radius_none display_block gallery-loader hidden" ><img alt="" src="{{asset('assets')}}/img/loading-sm.gif"> Loading...</button>
            @{{else}}
                <button class="btn btn-danger btn-lg btn-block border_radius_none display_block gallery-loader completed" >Loaded all @{{ total }} results</button>
            @{{/if}}
            </div>
        </div>
</script>
<script id="template-pager-gallery" type="text/x-handlebars-template">
        <div class="row"  style=" border-top: 3px solid #e0e0e0;margin-top: 10px;">
            <div class="col-lg-12">
                <h4 class="pager" style="color: #bd1f31"> Viewing: Total @{{numberWithComma to}} of @{{numberWithComma total}}</h4>
            </div>
        </div>

</script>

@stop
