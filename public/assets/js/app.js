/**
 * Author : Shahjahan Russell on 6/1/14.
 * Email : russell@nextgen-soft.com, shadow2burn@gmail.com
 * Web : www.nextgen-soft.com
 */
'use strict';
var PNOBJ = PNOBJ || {};
var drag_flag = true;
var zoom_flag = true;
var center_flag = true;
var dragprogerssIn = true;
var maker_clicked = false;
var cluster_flag = false;
var cluster_maxzoom = 21;
var toggle_flag = true;
var map_id;
var cluster_click = false;

var myOptions = {                            
    disableAutoPan: true,
    maxWidth: 272,    
    zIndex: null,     
    closeBoxURL: "",                                           
    infoBoxClearance: new google.maps.Size(1, 1),
    isHidden: false,
    pane: "floatPane",
    enableEventPropagation: false,
    pixelOffset: new google.maps.Size(30 ,-60),      
};

var infobox = new InfoBox(myOptions);      

if(is_logged_in){
    $.ajax({
        url: baseurl+'/visitor/favorites',
        async: false,
        type: 'GET'
    })
    .done(function(result) {        
        if(result.length>0){
            favorites = result;
        }
    });

}

PNOBJ = {
    directionsDisplay: '',
    directionsService: '',
    Model: {
        get: function(query) {            
            return $.ajax({
                    url: baseurl + '/api/v1/search',
                    data: query,
                    type: 'GET'
                });
          
        },
        getById: function(id) {
            return $.ajax({
                url: baseurl + '/api/v1/search/' + id
            });

        }
    },

    Controller: {
        showPhotoListing: function(conds) {

            var promise = new PNOBJ.Model.get(conds);
            $('.search_details_content').find('.search_details').remove();
            $('.search_details_content').find('.ad-common').remove();
        
            promise.success(function(data) {

                if(data.error){
                    data.success=false;
                    var list_sidebar_html = PNOBJ.Helpers.renderInHandlebar('#template-small-list', data);
                    var photo_view_html = PNOBJ.Helpers.renderInHandlebar('#template-details-list', data);
                    $('.side_bar_listing').empty().html(list_sidebar_html);
                    $('.search_details_content').empty().html(photo_view_html);
                }else{
                    data=PNOBJ.Helpers.prepareFavorites(data);
                    var params={};window.location.search.replace(/[?&]+([^=&]+)=([^&]*)/gi,function(str,key,value){params[key] = value;});
                    if(data.total>20){
                        params.page=data.current_page+1;
                        var next_page=window.location.hostname + window.location.pathname+'?'+ $.param(params);
                        data.next_page_link=next_page;
                    }

                    if(data.current_page>1){
                        params.page=data.current_page-1;
                        var prv_page=window.location.hostname + window.location.pathname+'?'+ $.param(params);
                        data.prv_page_link=prv_page;
                    }


                    var list_sidebar_html = PNOBJ.Helpers.renderInHandlebar('#template-small-list', data);
                    var photo_view_html = PNOBJ.Helpers.renderInHandlebar('#template-details-list', data);

                    $('.side_bar_listing').empty().html(list_sidebar_html);
                    $('.search_details_content').empty().html(photo_view_html);
                    PNOBJ.Helpers.showSlider(data);
                    $('img.lazy').lazyload({
                        container: $('.side_bar_listing')
                    });

                }

            }).error(function(err) {
                //console.log(err);
            });

        },

        showGalleryListing: function(event,conds,container) {

            var promise = PNOBJ.Model.get(conds);
            var complete_status= false;

            promise.success(function(data) {
                if(data.error){
                    complete_status=true;
                    data.success=false;
                    var pager_loader_html = PNOBJ.Helpers.renderInHandlebar('#template-loader-gallery', data);
                    $('.page-loader').html(pager_loader_html);
                }else{
                    complete_status=false;
                    data.success=true;
                    data=PNOBJ.Helpers.prepareFavorites(data);

                    var pager_loader_html = PNOBJ.Helpers.renderInHandlebar('#template-loader-gallery', data);
                    var result_view_html = PNOBJ.Helpers.renderInHandlebar('#template-search-result-numbers', data);

                    if(event=='load'){
                        data.init_load=true;
                        var list_view_html = PNOBJ.Helpers.renderInHandlebar('#template-single-property-list', data);
                        container.html(list_view_html);
                    }else if(event=='scroll'){
                        var list_view_html = PNOBJ.Helpers.renderInHandlebar('#template-single-property-list', data);
                        container.append(list_view_html);
                    }

                    $('.page-loader').html(pager_loader_html);
                    $('#search-filter').html(result_view_html);

                    if ($('.property').hasClass('masonry')) {

                        if(event=='load') {
                                container.masonry({
                                    gutter: 15,
                                    isFitWidth: true,
                                    itemSelector: '.property'
                                });
                            }else{
                                container.masonry('appended',list_view_html,true);
                                container.masonry('reloadItems');
                                container.masonry();
                            }
                        
                        $('.gallery-loader').addClass('hidden');
                        // container.imagesLoaded(function() {
                            

                        // });
                    }

                }

            }).error(function(err) {
                console.log(err);
            });

        },
        showPopularListing: function(number) {

            var limit = number ? number : 3;
            var search_query = {
                sort: 'popular',
                limit: limit
            };
            var promise = PNOBJ.Model.get(search_query);

            promise.success(function(data) {
                data=PNOBJ.Helpers.prepareFavorites(data);
                var popular_view_html = PNOBJ.Helpers.renderInHandlebar('#template-popular-listing', data);
                $('.popular_listing').html(popular_view_html);

            }).error(function(err) {
                //console.log(err);
            });
        },

        showDetails: function(id) {

            var promise = PNOBJ.Model.getById(id);

            promise.success(function(data) {

                var template = $('#listing_details').html();
                Mustache.parse(template); // optional, speeds up future uses
                var rendered = Mustache.render(template, data);
                $('#myModal .modal-body').html(rendered);
                $('#myModal').modal('show');
            })
        },

        showMap: function(lat, lng, id) {

            var myCenter = new google.maps.LatLng(lat, lng);

            var marker = new google.maps.Marker({
                position: myCenter,
                icon: baseurl + '/assets/img/map-marker.png'
            });

            var mapProp = {
                center: myCenter,
                zoom: 14,
                // draggable: false,
                scrollwheel: false,
                mapTypeId: google.maps.MapTypeId.ROADMAP
            };

            var map = new google.maps.Map(document.getElementById(id), mapProp);
            marker.setMap(map);
            return map;
        },
        initDirection: function(map, panelID) {

            // to initiate the direction display service so that it can render
            PNOBJ.directionsDisplay = new google.maps.DirectionsRenderer();
            PNOBJ.directionsDisplay.setMap(map);
            PNOBJ.directionsDisplay.setPanel(document.getElementById(panelID));
            PNOBJ.directionsService = new google.maps.DirectionsService();
        },
        showDistanceDirection: function(start, end, panelID) {

            var request = {
                origin: start,
                destination: end,
                travelMode: google.maps.TravelMode.DRIVING
            };
            PNOBJ.directionsService.route(request, function(response, status) {
                $('#' + panelID).empty();
                $('#' + panelID).addClass(panelID);
                if (status == google.maps.DirectionsStatus.OK) {
                    $('#' + panelID).append('<p> Distance : <strong>' + response.routes[0].legs[0].distance.text + '</strong> | Duration : <strong>' + response.routes[0].legs[0].duration.text + '</strong>');
                    PNOBJ.directionsDisplay.setDirections(response);
                } else if (status == google.maps.DirectionsStatus.NOT_FOUND || status == google.maps.DirectionsStatus.ZERO_RESULTS) {
                    $('#' + panelID).html('Indicates at least one of the locations specified in the request\'s <strong>FROM:</strong>  or <strong>TO:</strong> could not be geocoded.');
                } else {
                    $('#' + panelID).html('Unknown Errors');
                }
            });


        },


        loadMapWithMarkers: function(conds, id) {            
            var map_data = [];
            var promise = PNOBJ.Model.get(conds);
            var center_coor = [];
            var bounds = [];
            var zoom_level = conds.zoom ? Number(conds.zoom) : 10;  
            map_id = id;

            if(maker_clicked == false){                                    
                $('#panel-box').fadeIn();                 
            }                                                                

            promise.success(function(data) {

                bounds = new google.maps.LatLngBounds();

                var i = 0;
                var center_coor_pos = [];
                
                if(!(typeof(data.data)  === "undefined")){
                    var total_lat = 0, total_long = 0, count =0;                    
                    $.each(data.data, function(index, val) {
                        var prepare = {};                                   
                        if (val.latitude) {
                            bounds.extend(new google.maps.LatLng(val.latitude, val.longitude)); 
                            total_lat += parseFloat(val.latitude);
                            total_long += parseFloat(val.longitude); 
                            count++;                          
                        }

                        if (val.latitude)
                            prepare.latLng = [val.latitude, val.longitude];
                        else
                            prepare.address = val.full_address;
                        var new_label = '';
                        if (val.status == 'New') {
                            new_label = '<div class="new_tag_2">' + '<img src="' + baseurl + '/assets/img/icons/status/new.png" alt="New"/>' + '</div>';
                        }else if (val.status == 'Active'){
                            new_label = '<div class="new_tag_2">' + '<img src="' + baseurl + '/assets/img/icons/status/active.png" alt="Active"/>' + '</div>';
                        }

                        prepare.data = '<div class="map-info">' + new_label + '<div class="star_tag">' + '<button type="button" class="btn btn-default btn-lg">' + '<span class="glyphicon glyphicon-star"></span></button>' + '</div>' + '<div class="listing_img">' + '<img src="' + val.main_photo + '" alt="' + val.listing_id + '"/>' + '</div>' + '<div class="listing_content">' + '<div class="content_top clearfix">' + '<h5 class="pull-left"><b>' + val.unparsed_address + '</b></h5>' + '<span class="pull-right margin-top-10">' + val.formatedPrice + '</span>' + '</div>' + '<p class="property_type">' + val.property_type + '<img class="pull-right" src="' + val.mls_logo + '" alt="' + val.listing_id + '"></p><div class="clearfix"></div>' + '<div class="see_details clearfix">' + '<a href="'+ val.url +'" data-id="' + val.listing_id + '" data-lng="' + val.longitude + '" data-lat="' + val.latitude + '" class="btn btn-danger pull-left show_details_listing" style="display: block;">See details</a>' + '<span class="pull-right"><b>' + val.bedrooms + '</b> BEDS  <b>' + val.full_baths + '</b> BATHS <b>10</b> ACRES</span>' + '</div>' + '</div>' + '</div>';

                        prepare.id = 'gmap3_' + i + '1';
                        prepare.options = {
                            labelContent: PNOBJ.Helpers.getRepString(val.list_price),
                            labelAnchor: new google.maps.Point(20, -2),
                            labelClass: 'labels',
                            labelStyle: {
                                opacity: 0.90
                            }
                        };
                        map_data[i] = prepare;
                        i++;
                    });       

                    center_coor_pos = [ total_lat/count, total_long/count ];
                }
                console.log(count);
                if(count > 100 ){
                    cluster_flag = true;
                    cluster_maxzoom = zoom_level+1;
                }else{
                    cluster_flag = false;
                    cluster_maxzoom = true;
                }                      

                var map_option = {};                
                if( center_flag == true ){
                    
                    if( typeof(conds.nelat)  === "undefined"  && typeof(conds.swlat)  === "undefined"){                
                        center_coor = center_coor_pos;

                    }else{                    
                        // Get center_Coor
                        var coor = [ [conds.nelat, conds.nelng],[conds.swlat, conds.swlng]];                    
                        center_coor = GetCenterFromDegrees(coor);                        
                    }
                    center_flag = false;                                       

                    map_option = {
                            center: center_coor, 
                            zoom: zoom_level                           
                        }
                }                                

                $(id).gmap3('clear');                

                var timer;   
                //infobox = new InfoBox(myOptions);      

                google.maps.event.addListener(infobox, 'domready', function() {
                    $('.show_details_listing').click(function(event) {
                        event.preventDefault();
                        var latitude = $(this).data('lat');
                        var longitude = $(this).data('lng');

                        var url_listing = $(this).attr('href');
                        
                        if(is_logged_in || (!is_logged_in && more_details_counter<more_details_limit)){
                            $.ajax({
                                type: "GET",
                                url: url_listing,
                                dataType: 'html',
                                cache: true

                            }).done(function( data ) {

                                history.pushState(null, null, url_listing);

                                $('#view_full_details').empty().html(data);
                                $('#view_full_details').modal("show");

                                var myCenter = new google.maps.LatLng(latitude, longitude);

                                var marker = new google.maps.Marker({
                                    position: myCenter,
                                    icon: baseurl + '/assets/img/map-marker.png'
                                });

                                var mapProp = {
                                    center: myCenter,
                                    zoom: 14,
                                    // draggable: false,
                                    scrollwheel: false,
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                };

                                var map = new google.maps.Map(document.getElementById('show_map'), mapProp);
                                marker.setMap(map);
                                $('#view_full_details').on('shown.bs.modal', function () {
                                    window.setTimeout(function () {

                                        var carousel = '.carousel-single-listing';
                                        var slider = '.slider-single-listing';
                                        $(carousel).flexslider({
                                            animation: "slide",
                                            controlNav: false,
                                            animationLoop: false,
                                            slideshow: false,
                                            itemWidth: 120,
                                            itemMargin: 5,
                                            asNavFor: slider
                                        });

                                        $(slider).flexslider({
                                            animation: "slide",
                                            controlNav: false,
                                            animationLoop: false,
                                            slideshow: false,
                                            sync: carousel
                                        });

                                        google.maps.event.trigger(map, "resize");
                                        map.panTo(myCenter);

                                    }, 300);

                                });

                                // direction initialization
                                PNOBJ.Controller.initDirection(map,'direction_panel');
                                //more_details_counter for unsigned visitor

                            });
                            more_details_counter=parseInt(more_details_counter)+1;
                            $.cookie('more_details_counter', more_details_counter, { expires: 365, path: '/' });
                            //$.cookie("more_details_counter", more_details_counter);
                        }else{
                            $("#free_mls_reg").modal('show');
                            //$.removeCookie('more_details_counter');
                            //$.cookie('more_details_counter', 0, { expires: 365, path: '/' });
                            //more_details_counter=$.cookie("more_details_counter");
                        }
                    });
                });
                
                cluster_click = false;

                $(id).gmap3({
                    defaults: {
                        classes: {
                            Marker: MarkerWithLabel
                        }
                    },                    
                    map: {
                        options: map_option,                        
                        events: {                                                        
                            zoom_changed: function(map) {
                                if (zoom_flag == true && cluster_click == false ){                                        
                                    if ($(id).find(".infoBox").length > 0) {                                        
                                        infobox.close();
                                    }  
                                    
                                    var zoom = map.getZoom();                                    
                                    bounds = map.getBounds();
                                    var nelat = bounds.getNorthEast().lat();
                                    var nelng = bounds.getNorthEast().lng();
                                    var swlat = bounds.getSouthWest().lat();
                                    var swlng = bounds.getSouthWest().lng();                                

                                    var url = window.location.href;
                                    url = url.split("?")[0].split("#")[0];

                                    //add a sinle name/value
                                    qs.add('nelat', nelat);
                                    qs.add('nelng', nelng);
                                    qs.add('swlat', swlat);
                                    qs.add('swlng', swlng);
                                    qs.add('map', 1);
                                    qs.add('zoom', zoom);

                                    url += '?' + qs;
                                    History.pushState(null, null, url);
                                    search_query['nelat'] = nelat;
                                    search_query['nelng'] = nelng;
                                    search_query['swlat'] = swlat;
                                    search_query['swlng'] = swlng;
                                    search_query['zoom'] = zoom;
                                    search_query['limit'] = 0;
                                    
                                    //map.setZoom(zoom);

                                    $(id).gmap3('clear');
                                    clearTimeout(timer);
                                    timer = setTimeout(function() {                                        
                                        PNOBJ.Controller.loadMapWithMarkers(search_query, id);                                        
                                        zoom_flag = true;                                                                                
                                    }, 500);

                                    zoom_flag = false;      
                                    maker_clicked = false;  
                                    History.pushState(nelat,'',url);                                                                        
                                }

                            },                            
                            dragend: function(map) {                                
                                if (drag_flag == true){  

                                    if ($(id).find(".infoBox").length > 0) {                                        
                                        infobox.close();
                                    }   

                                    var zoom = map.getZoom();
                                    bounds = map.getBounds();
                                    var nelat = bounds.getNorthEast().lat();
                                    var nelng = bounds.getNorthEast().lng();
                                    var swlat = bounds.getSouthWest().lat();
                                    var swlng = bounds.getSouthWest().lng();                                

                                    var url = window.location.href;
                                    url = url.split("?")[0].split("#")[0];

                                    //add a sinle name/value
                                    qs.add('nelat', nelat);
                                    qs.add('nelng', nelng);
                                    qs.add('swlat', swlat);
                                    qs.add('swlng', swlng);
                                    qs.add('map', 1);
                                    qs.add('zoom', zoom);

                                    url += '?' + qs;
                                    History.pushState(null, null, url);
                                    search_query['nelat'] = nelat;
                                    search_query['nelng'] = nelng;
                                    search_query['swlat'] = swlat;
                                    search_query['swlng'] = swlng;
                                    search_query['zoom'] = zoom;
                                    search_query['limit'] = 0;
                                    
                                    //map.setZoom(zoom);
                                    $(id).gmap3('clear');                                
                                    clearTimeout(timer);
                                    timer = setTimeout(function() {
                                        PNOBJ.Controller.loadMapWithMarkers(search_query, id);                                        
                                        drag_flag = true;                                                                                                                        
                                    }, 500);
                                    drag_flag = false;      
                                    maker_clicked = false;                                                                                 
                                    History.pushState(nelat,'',url);
                                }   
                            },
                            click: function() {   

                                if ($(id).find(".infoBox").length > 0) {                                    
                                    infobox.close();
                                }   

                            }
                        }
                    },
                   /* panel: {
                        options: {
                            content: '<div id="panel-box" style="opacity:1;">' +
                                '<div class="panel-logo"><img src="/assets/img/loading_panel.png"></div>' +
                                '<div class="panel-loading"><img src="/assets/img/panel-loading.gif"><p>Updating Results...</p></div>'+
                                '</div>',
                            middle: true,                            
                            center: true
                        }
                    },*/
                    marker: {
                        name: "markers",
                        values: map_data,
                        options: {
                            draggable: false,
                            icon: baseurl + '/assets/img/map-marker-red.png'
                        },
                        callback: function(markers) {  

                            if(cluster_flag == true){
                                data = [];
                            }

                            /*var map = $(this).gmap3('get'); 
                            var mcOptions = {
                                gridSize: 200,
                                maxZoom: 12,
                                minimumClusterSize: 15,
                                force:cluster_flag,                                
                                imagePath: baseurl + '/assets/img/clustering-circle'    
                            };
                            var a = new MarkerClusterer(map, markers, mcOptions);*/

                            setTimeout(function() {                                                                          
                                $('#panel-box').fadeOut();                                    
                            }, 500); 

                            var list_sidebar_html = PNOBJ.Helpers.renderInHandlebar('#template-small-list', data);
                            $('.side_bar_listing').empty().html(list_sidebar_html);

                        },
                        cluster: {                               
                            radius: 200,
                            averageCenter:true,
                            maxZoom: cluster_maxzoom,
                            force: cluster_flag,          
                            events: { // events trigged by clusters
                                click: function(cluster, event, context) {
                                    var map = $(this).gmap3('get');
                                    var data = context.data; 
                                    var markers = context.data.markers;
                                    var limit = markers.length;
                                    var change_zoom;                                    

                                    if (limit > 1200){
                                        change_zoom = map.getZoom() + 3;                                        
                                    }else if(limit > 600){
                                        change_zoom = map.getZoom() + 2;                                        
                                    }else{
                                        change_zoom = map.getZoom() + 1;                                        
                                    }

                                    var scale = Math.pow(2, change_zoom);

                                    map.panTo(data.latLng);                                                                          
                                    cluster_click = true;                                    

                                    bounds = map.getBounds();                                    
                                 
                                    var width = $(id).width()/2;
                                    var height = $(id).height()/2;
                                    var nelat = ((data.latLng.lat()* scale) - height)/ scale;
                                    var nelng = ((data.latLng.lng()* scale) + width)/ scale;
                                    var swlat = ((data.latLng.lat()* scale) + height)/ scale;
                                    var swlng = ((data.latLng.lng()* scale) - width)/ scale;                                   

                                    var url = window.location.href;
                                    url = url.split("?")[0].split("#")[0];                                   

                                    //add a sinle name/value
                                    qs.add('nelat', nelat);
                                    qs.add('nelng', nelng);
                                    qs.add('swlat', swlat);
                                    qs.add('swlng', swlng);
                                    qs.add('map', 1);
                                    qs.add('zoom', change_zoom );                                    

                                    url += '?' + qs;
                                    History.pushState(null, null, url);
                                    search_query['nelat'] = nelat;
                                    search_query['nelng'] = nelng;
                                    search_query['swlat'] = swlat;
                                    search_query['swlng'] = swlng;
                                    search_query['zoom'] = change_zoom ;
                                    search_query['limit'] = limit;                                    
                                    
                                    $(id).gmap3('clear');                                                                    
                                    
                                    PNOBJ.Controller.loadMapWithMarkers(search_query, id);   
                                    History.pushState(nelat,'',url); 
                                    
                                    map.setZoom(change_zoom);                                    
                                }
                            },                              
                                
                            0: {
                                content: '<div class="cluster cluster0">CLUSTER_COUNT</div>',
                                width: 32,
                                height: 32
                            },
                            20: {
                                content: '<div class="cluster cluster10">CLUSTER_COUNT</div>',
                                width: 42,
                                height: 42
                            },
                            50: {
                                content: '<div class="cluster cluster40">CLUSTER_COUNT</div>',
                                width: 52,
                                height: 52
                            },
                            100: {
                                content: '<div class="cluster cluster100">CLUSTER_COUNT</div>',
                                width: 65,
                                height: 65
                            }
                            
                        },
                        events: {
                            click: function(marker, event, context) {                                
                                maker_clicked = true;                                
                                var map = $(this).gmap3('get');
                                var currentMarker = map.currentMarker || false;

                                if( currentMarker ){
                                    currentMarker.setOptions({
                                        icon : baseurl + '/assets/img/map-marker-red.png'
                                    });
                                }
                                
                                marker.setOptions({
                                    icon : baseurl + '/assets/img/map-marker-blue.png'
                                });

                                map.currentMarker = marker;

                                $('div.search_result').scrollTo('#' + context.id, 1000, {
                                    offset: -10
                                });
                                $('.goto').removeClass('active');
                                $('#' + context.id).addClass('active');

                                if (infobox.getPosition() == marker.getPosition() && $(id).find(".infoBox").length > 0) {
                                    infobox.close();
                                } else {    
                                    var map = $(this).gmap3('get');                                    
                                    var marker_postion = marker.getPosition();   
                                    var dLongitude = (150 / 256 ) * ( 360 / Math.pow(2, map.getZoom()) );
                                    var dLatitude = (200 / 256 ) * ( 180 / Math.pow(2, map.getZoom()) );

                                    var latlng = new google.maps.LatLng( marker_postion.lat()-dLatitude, marker_postion.lng()+dLongitude);

                                    infobox.setContent(context.data);                                     
                                    infobox.open(map, marker);    
                                    
                                    map.panTo(latlng);
                                }   
                                
                            }

                        }
                    }
                });

            }).error(function(err) {
                console.log(err);
            });
        },
       
    },

    Helpers: {
        prepareFavorites: function(data){
            var form_data=data;
            var fav=false;           
            if(favorites.length>0){
                $.each(form_data.data, function(index, val) {
                    fav=false;
                    $.each(favorites,function(f_ind,f_val){
                        if(val.listing_id===f_val){
                            fav=true;
                        }
                    });
                    if(fav===true)
                        form_data.data[index].favorite=true;
                    else
                        form_data.data[index].favorite=false;
                });
            }

            return form_data;

        },
        doFormat: function(data) {
            $.each(data.data, function(index, val) {});
            return data;
        },
        renderInHandlebar: function(template_id, data) {
            var content = $(template_id).html();
            var template = Handlebars.compile(content);
            return template(data);

        },
        makeslug: function(Text) {
            return Text
                .toLowerCase()
                .replace(/[^\w ]+/g, '')
                .replace(/ +/g, '-');
        },
        getRepString: function(rep) {
            rep = rep + '';
            if (rep < 1000) {
                return rep;
            }
            if (rep < 10000) {
                return rep.charAt(0) + ',' + rep.substring(1);
            }
            return (rep / 1000).toFixed(rep % 1000 != 0) + 'k';
        },
        showSlider: function(data) {
            $.each(data.data, function(index, val) {
                var carousel = '.carousel-' + val.listing_id;
                var slider = '.slider-' + val.listing_id;
                $(carousel).flexslider({
                    animation: 'slide',
                    controlNav: false,
                    animationLoop: false,
                    slideshow: false,
                    itemWidth: 120,
                    itemMargin: 5,
                    asNavFor: slider
                });

                $(slider).flexslider({
                    animation: 'slide',
                    controlNav: false,
                    animationLoop: false,
                    slideshow: false,
                    sync: carousel,
                    start: function(slider) {
                        // lazy load
                        $(slider).find('img.lazy').slice(0, 5).each(function() {
                            var src = $(this).attr('data-src');
                            $(this).attr('src', src).removeAttr('data-src').removeClass('lazy');
                        });
                    },
                    before: function(slider) {
                        // lazy load
                        var slide = $(slider).find('.slides').children().eq(slider.animatingTo + 1).find('img');
                        var src = slide.attr('data-src');
                        slide.attr('src', src).removeAttr('data-src').removeClass('lazy');
                    }
                });
            });
        }
    }
}
Handlebars.registerHelper ("compare", function (p1, options) {
    if(p1==3){
        return options.fn(this);
    }
    else
        return false;

});


function GetCenterFromDegrees(data)
{
    if (!jQuery.isArray(data)) return FALSE;

    var num_coords = data.length;

    var X = 0.0;
    var Y = 0.0;
    var Z = 0.0;
    var lat, lon, a, b,c;

    for(var i in data)
    {
        lat = data[i][0] * Math.PI / 180;
        lon = data[i][1] * Math.PI / 180;

        a = Math.cos(lat) * Math.cos(lon);
        b = Math.cos(lat) * Math.sin(lon);
        c = Math.sin(lat);

        X += a;
        Y += b;
        Z += c;
    }

    X /= num_coords;
    Y /= num_coords;
    Z /= num_coords;

    lon = Math.atan2(Y, X);
    var hyp = Math.sqrt(X * X + Y * Y);
    lat = Math.atan2(Z, hyp);

    return [lat * 180 / Math.PI , lon * 180 / Math.PI ];
}

$(document).ready(function(){
    
    $(".map-sidebar-toggle").click(function(){        
        $(this).find("span").toggle();     

        if(toggle_flag == true){
            $(".search_result").css("display", "none");
            $(".search_details_content").removeClass("col-lg-9 col-md-9 col-sm-9");
            $(".search_details_content").addClass("col-lg-12 col-md-12 col-sm-12");
            toggle_flag = false;     
            
        }else{
            $(".search_result").css("display", "block");
            $(".search_details_content").removeClass("col-lg-12 col-md-12 col-sm-12");
            $(".search_details_content").addClass("col-lg-9 col-md-9 col-sm-9");
            toggle_flag = true;            
        }
        
        var map = $(map_id).gmap3('get');
        
        google.maps.event.trigger(map, 'resize');        
        
        var zoom = map.getZoom();

        var bounds = map.getBounds();        
        var nelat = bounds.getNorthEast().lat();
        var nelng = bounds.getNorthEast().lng();
        var swlat = bounds.getSouthWest().lat();
        var swlng = bounds.getSouthWest().lng();    
        
        var url = window.location.href;
        url = url.split("?")[0].split("#")[0];        
        qs.add('nelat', nelat);
        qs.add('nelng', nelng);
        qs.add('swlat', swlat);
        qs.add('swlng', swlng);
        qs.add('map', 1);
        qs.add('zoom', zoom);

        url += '?' + qs;
        History.pushState(null, null, url);
        search_query['nelat'] = nelat;
        search_query['nelng'] = nelng;
        search_query['swlat'] = swlat;
        search_query['swlng'] = swlng;
        search_query['zoom'] = zoom;
                
        PNOBJ.Controller.loadMapWithMarkers(search_query, map_id);         

        var width = $("#load_map").width();
        var height = $("#load_map").height();                
        $("#panel-box").css({"left":width/2-140 +"px" , "top": height/2-70+"px", "opacity": 1 });                      
    });   

});