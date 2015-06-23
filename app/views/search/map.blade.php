@extends('layouts.default')
@section('assets-js')
@parent
<script>


</script>
<?php echo HTML::script('assets/js/markerwithlabel.js'); ?>
<?php echo HTML::script('assets/js/gmap3.js'); ?>
<?php echo HTML::script('assets/js/clustermarker.js'); ?>
<?php echo HTML::script('assets/js/search.js'); ?>

<script>
    
    $(document).ready(function(){        
        var reduce_height = 200;
        $(window).resize(function() {
            $('.search_details_content').height($(window).height()-reduce_height );
            $('.search_result').height($(window).height()-reduce_height );
        });
        $('.search_details_content').height($(window).height()-reduce_height );
        $('.search_result').height($(window).height()-reduce_height );
        
        if( typeof search_query.nelat == 'undefined' && typeof search_query.nelng == 'undefined' ){
            search_query = {
                status: "A",
                nelat: "42.28478464401083",
                nelng: "-70.0031188219645",
                swlat: "41.813657010019845",
                swlng: "-71.67441398798013",
                zoom: "10"    
            }            
        }
        
        PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');

        var width = $("#load_map").width();
        var height = $("#load_map").height();                
        $("#panel-box").css({"left":width/2-140 +"px" , "top": height/2-70+"px", "opacity": 1 });

        $('body').on('click','.goto',function(e){
            e.preventDefault();
            var id = $(this).attr('id');
            var market = $('#load_map').gmap3({
                get:{
                    id: id
                }
            });
            google.maps.event.trigger(market, 'click');

        });
        // filter search
        $("#sort_by").change(function(e){
            search_query.sort=$(this).val();
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
            keep_history(search_query);
        });

        $("#min_price").change(function(e){
            search_query.min_price=$(this).val();
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
            keep_history(search_query);
        });
        $("#max_price").change(function(e){
            search_query.max_price=$(this).val();
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
            keep_history(search_query);
        });
        $(".beds").click(function(e){
            search_query.beds=$(this).val();
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
            keep_history(search_query);
        });
        $(".baths").click(function(e){
            search_query.baths=$(this).val();
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
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
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
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
            PNOBJ.Controller.loadMapWithMarkers(search_query,'#load_map');
            keep_history(search_query);
        });

       
      /*  google.maps.event.addListener(map, 'zoom_changed', function() {
            console.log('Zoom Changed');
        });

        google.maps.event.addListener(map,"bounds_changed",function() {
            console.log('Bound Changed'); 
        });

        google.maps.event.addListener(map, 'idle', function() {
            var bounds = map.getBounds();
            var ne = bounds.getNorthEast();
            var sw = bounds.getSouthWest();
            $('#panel-box').fadeOut();
        });*/

});

</script>
@stop
@section('content')

<div class="container-fluid margin_top_after_sub_menu map-search">
    <div class="row">
        <a class="btn btn-sm btn-default map-sidebar-toggle" href="#collapse">            
            <span class="glyphicon glyphicon-arrow-left"><b>Hide</b></span>
            <span class="glyphicon glyphicon-arrow-right" style="display:none"><b>Show</b></span>
        </a>
        <div class="col-lg-3 col-md-3 col-sm-3  search_result">            
            <h5>SEARCH RESULTS</h5>
            <hr>
            <div class="side_bar_listing">

            </div>
        </div>

        <div class="col-lg-9 col-md-9 col-sm-9 search_details_content">
            <div id="panel-box">
                    <div class="panel-logo"><img src="/assets/img/loading_panel.png"></div>
                    <div class="panel-loading"><img src="/assets/img/panel-loading.gif"><p>Updating Results...</p></div>
            </div>            
            <div id="load_map">
                
            </div>
        </div>
    </div>

</div>

<script id="template-small-list" type="text/x-handlebars-template">
    @{{#each data }}
    <div>
        <a href="#" class="goto" data-target="go-@{{listing_id}}" id="gmap3_@{{@index}}1">
            <div class="thumbnail">
                @{{#if photos_count}}
                <img src="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg"
                alt="@{{listing_id}}"/>
                @{{/if}}
                <div class="caption clearfix search_result_content">
                    <div class="caption_addr">
                        <p><strong>@{{unparsed_address}}</strong></p>
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
<script id="listing_details" type="x-tmpl-mustache">
    <p>Details Page</p>
    @{{property_type}}<br>
    @{{remarks}}
</script>
@stop

