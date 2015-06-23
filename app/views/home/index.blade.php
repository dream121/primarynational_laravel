@extends('layouts.default')
@section('assets-js')
@parent
<script> 
    $(document).ready(function(){
        PNOBJ.Controller.showPopularListing(3);
        $(".list_circle").hover(
            function(){
                $(this).find("img").css("opacity",".50");
            },
            function(){
             $(this).find("img").css("opacity","1");
        });

    // Initialize ajax autocomplete:
    $('#auto_complete').devbridgeAutocomplete({
        serviceUrl: baseurl+'/suggest/',
        // lookup: teams,
        triggerSelectOnValidInput:false,
        showNoSuggestionNotice: true,
        noSuggestionNotice: 'Sorry, no matching results',
        groupBy: 'category',
        onSelect: function(suggestion) {
            $('#selction-ajax').html('You selected: ' + suggestion.data.category + ' of ' + suggestion.value);
            $('#auto_complete').attr('name',suggestion.data.category.toLowerCase().replace(' ','_'));
            if(suggestion.data.category.toLowerCase()==='address'){
                $('#max_price').attr('name','');
                $('#min_price').attr('name','');
                $('.beds').attr('name','');
            }

            $('.form').submit();
            // console.log(suggestion);
        },
        onHint: function (hint) {
           console.log(hint);
        },
        onSearchComplete: function(data){
             console.log(data);

        },/*
        formatResult: function (suggestion, currentValue) {
            console.log(suggestion);
            console.log(currentValue);
        },*/
        beforeRender: function (container) {
            console.log(container);
        },
        onInvalidateSelection: function() {
            $('#selction-ajax').html('You selected: none');
        }
    });

    $("#price_drop_down").click(function(e){
        e.preventDefault();
        $('.dropdown>a').removeClass('hover');
        $(this).addClass('hover');
        $(".price_drop").toggle();
        $(".beds_drop").hide();
    });
    $("#beds_drop_down").click(function(e){
        e.preventDefault();
        $('.dropdown>a').removeClass('hover');
        $(this).addClass('hover');
        $(".beds_drop").toggle();
        $(".price_drop").hide();
    });

    $(".list_circle").hover(
        function(){
            $(this).find("img").css("opacity",".50");
        },
        function(){
            $(this).find("img").css("opacity","1");
        }
    );

})
</script>
@stop
@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="slider_content  max_search">
            <div class="logo">
                <img src="{{asset('assets/img/logo.png')}}" alt="PrimaryNational Logo"/>
            </div>
            <div class="slider_text">
                <h3>Lexington: {{number_format($total_property)}} MLS Listings</h3>
            </div>
            <div class="search">
                <h2>Find your home</h2>

                {{ Form::open(array('url' => 'search', 'method' => 'get','class'=>'form','role'=>'form' )) }}
                    <div class="row">
                        <div class="col-lg-1 col-md-1 col-sm-1 col-xs-12">
                            <div class="glyphicon glyphicon-search gylp_search_icon"></div>
                        </div>
                        <div class="col-lg-6 col-md-5 col-sm-5 col-xs-12">
                            <input id="auto_complete" class="form-control input-lg" name="query" type="text" placeholder="Type any area, address, zip etc" >
                            <div id="selction-ajax"></div>
                        </div>
                        <div class="col-sm-3">
                            <div class="row">
                                <ul class="nav navbar-nav search_dropdown" >
                                    <li class="dropdown price">
                                        <a class="dropdown-toggle" role="button" href="#" id="price_drop_down" data-toggle="dropdown">Price <b class="caret"></b></a>
                                        <ul aria-labelledby="price_drop" role="menu" class="dropdown-menu price_drop" style="display: none;">
                                            <li role="presentation">
                                                <div class="col-lg-5 col-xs-5">
                                                    <select class="form-control" name="min_price" id="min_price">
                                                        <option value="any">$ No Min</option>
                                                        <option value="50000">$50,000</option>
                                                        <option value="60000">$60,000</option>
                                                        <option value="70000">$70,000</option>
                                                        <option value="80000">$80,000</option>
                                                        <option value="90000">$90,000</option>
                                                        <option value="100000">$100,000</option>
                                                        <option value="125000">$125,000</option>
                                                        <option value="150000">$150,000</option>
                                                        <option value="175000">$175,000</option>
                                                        <option value="200000">$200,000</option>
                                                        <option value="225000">$225,000</option>
                                                        <option value="250000">$250,000</option>
                                                        <option value="275000">$275,000</option>
                                                        <option value="300000">$300,000</option>
                                                        <option value="325000">$325,000</option>
                                                        <option value="350000">$350,000</option>
                                                        <option value="375000">$375,000</option>
                                                        <option value="400000">$400,000</option>
                                                        <option value="425000">$425,000</option>
                                                        <option value="450000">$450,000</option>
                                                        <option value="475000">$475,000</option>
                                                        <option value="500000">$500,000</option>
                                                        <option value="550000">$550,000</option>
                                                        <option value="600000">$600,000</option>
                                                        <option value="650000">$650,000</option>
                                                        <option value="700000">$700,000</option>
                                                        <option value="750000">$750,000</option>
                                                        <option value="800000">$800,000</option>
                                                        <option value="850000">$850,000</option>
                                                        <option value="900000">$900,000</option>
                                                        <option value="950000">$950,000</option>
                                                        <option value="1000000">$1,000,000</option>
                                                        <option value="1250000">$1,250,000</option>
                                                        <option value="1500000">$1,500,000</option>
                                                        <option value="1750000">$1,750,000</option>
                                                        <option value="2000000">$2,000,000</option>
                                                        <option value="2250000">$2,250,000</option>
                                                        <option value="2500000">$2,500,000</option>
                                                        <option value="2750000">$2,750,000</option>
                                                        <option value="3000000">$3,000,000</option>
                                                        <option value="3500000">$3,500,000</option>
                                                        <option value="4000000">$4,000,000</option>
                                                        <option value="4500000">$4,500,000</option>
                                                        <option value="5000000">$5,000,000</option>
                                                        <option class="other" value="0">other</option>
                                                    </select>
                                                </div>
                                                <div class="col-lg-2 col-xs-2">
                                                    <h4>to</h4>
                                                </div>
                                                <div class="col-lg-5 col-xs-5">
                                                    <select class="form-control" name="max_price"  id="max_price">
                                                        <option value="any">$ No Max</option>
                                                        <option value="50000">$50,000</option>
                                                        <option value="60000">$60,000</option>
                                                        <option value="70000">$70,000</option>
                                                        <option value="80000">$80,000</option>
                                                        <option value="90000">$90,000</option>
                                                        <option value="100000">$100,000</option>
                                                        <option value="125000">$125,000</option>
                                                        <option value="150000">$150,000</option>
                                                        <option value="175000">$175,000</option>
                                                        <option value="200000">$200,000</option>
                                                        <option value="225000">$225,000</option>
                                                        <option value="250000">$250,000</option>
                                                        <option value="275000">$275,000</option>
                                                        <option value="300000">$300,000</option>
                                                        <option value="325000">$325,000</option>
                                                        <option value="350000">$350,000</option>
                                                        <option value="375000">$375,000</option>
                                                        <option value="400000">$400,000</option>
                                                        <option value="425000">$425,000</option>
                                                        <option value="450000">$450,000</option>
                                                        <option value="475000">$475,000</option>
                                                        <option value="500000">$500,000</option>
                                                        <option value="550000">$550,000</option>
                                                        <option value="600000">$600,000</option>
                                                        <option value="650000">$650,000</option>
                                                        <option value="700000">$700,000</option>
                                                        <option value="750000">$750,000</option>
                                                        <option value="800000">$800,000</option>
                                                        <option value="850000">$850,000</option>
                                                        <option value="900000">$900,000</option>
                                                        <option value="950000">$950,000</option>
                                                        <option value="1000000">$1,000,000</option>
                                                        <option value="1250000">$1,250,000</option>
                                                        <option value="1500000">$1,500,000</option>
                                                        <option value="1750000">$1,750,000</option>
                                                        <option value="2000000">$2,000,000</option>
                                                        <option value="2250000">$2,250,000</option>
                                                        <option value="2500000">$2,500,000</option>
                                                        <option value="2750000">$2,750,000</option>
                                                        <option value="3000000">$3,000,000</option>
                                                        <option value="3500000">$3,500,000</option>
                                                        <option value="4000000">$4,000,000</option>
                                                        <option value="4500000">$4,500,000</option>
                                                        <option value="5000000">$5,000,000</option>
                                                        <option value="10000000">$10,000,000</option>
                                                        <option class="other" value="0">other</option>
                                                    </select>
                                                </div>
                                            </li>
                                        </ul>
                                    </li>
                                    <li class="dropdown beds">
                                        <a href="#" id="beds_drop_down" role="button" class="dropdown-toggle"
                                           data-toggle="dropdown">Beds<b class="caret"></b></a>
                                        <ul class="dropdown-menu beds_drop" role="menu" aria-labelledby="beds_drop">
                                            <li class="list-group">
                                                <ul>
                                                    <li class="list-group-item">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="beds" type="radio" name="beds" value="any"
                                                                       checked>
                                                                Any
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="beds" type="radio" name="beds" value="2"
                                                                       >
                                                                2+
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="beds" type="radio" name="beds" value="3"
                                                                       >
                                                                3+
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="beds" type="radio" name="beds" value="4"
                                                                       >
                                                                4+
                                                            </label>
                                                        </div>
                                                    </li>
                                                    <li class="list-group-item">
                                                        <div class="radio">
                                                            <label>
                                                                <input class="beds" type="radio" name="beds" value="5"
                                                                       >
                                                                5+
                                                            </label>
                                                        </div>
                                                    </li>
                                                </ul>

                                            </li>
                                        </ul>
                                    </li>
                                </ul>
                            </div>
                        </div>

                        <div class="col-lg-2 col-md-2 col-sm-2">
                            <button type="submit" class="btn btn-danger btn-lg">GO!</button>
                        </div>
                    </div>
                {{ Form::close() }}
            </div>
        </div>

        <div id="carousel-example-generic" class="carousel slide" data-ride="carousel">
            <!-- Indicators -->
            @if($home_banner)
            <ol class="carousel-indicators">
                @foreach ($home_banner as $key=>$banner)
                <li data-target="#carousel-example-generic" data-slide-to="{{$key}}" class="{{$key==0?'active':''}}"></li>
                @endforeach
            </ol>
            @endif
            <!-- Wrapper for slides -->
            <div class="carousel-inner">
                @if($home_banner)
                @foreach ($home_banner as $key=>$banner)
                <div class="item {{$key==0?'active':''}}">
                    <img src="{{$banner->image_link_1}}" alt="{{$banner->title}}">
                </div>
                @endforeach
                @endif
            </div>
        </div>
    </div>
</div>

<div class="container-fluid hidden-xs">
    <div class="listing-widget">
        <div class="bnr_2_container clearfix width_90">
            <div class="row">
            <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="banner_link">
                    <a href="{{url('search/map?status=A')}}" class="list_circle" title="See All Listings">
                            <img src="{{asset('assets/img/bnr_pic_v1.jpg')}}" class="img-circle" alt="Map View"/>
                            <button class="btn btn-danger btn-large see_all">See All Listings</button>
                        </a>
                    </div>
                    <h3>Map view</h3>

                        <p>Google map, sidebar of properties</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="banner_link">
                        <a href="{{url('search/index?status=A')}}" class="list_circle" title="See All Listings">
                        <img src="{{asset('assets/img/bnr_pic_v2.jpg')}}" class="img-circle" alt="Photo View"/>
                        <button class="btn btn-danger btn-large see_all">See All Listings</button>
                        </a>
                    </div>
                    <h3>Photo view</h3>
                    <p>Large photo, sidebar of properties</p>
                </div>
                <div class="col-lg-4 col-md-4 col-sm-4 col-xs-4">
                    <div class="banner_link">
                        <a href="{{url('search/gallery?status=A')}}" class="list_circle" title="See All Listings">
                        <img src="{{asset('assets/img/bnr_pic_v3.jpg')}}" class="img-circle" alt="Gallery View"/>
                        <button class="btn btn-danger btn-large see_all">See All Listings</button>
                        </a>
                    </div>
                    <h3>Gallery view</h3>
                    <p>Photo gallery of properties</p>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid margin_right_none">

    <div class="row">
        <div class="col-lg-5 col-lg-offset-1 col-md-5">
            <div class="welcome">
                <div class="welcome_bg"></div>
                <h3>{{@$welcome_note->title}}</h3>
                {{@$welcome_note->content}}
            </div>
        </div>
        <div class="col-lg-6 col-md-6">
            <div class="row">
                <img class="img-responsive kitchen_photo" src="{{asset('assets/img/1.jpg')}}" alt=""/>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid bg_red clearfix">

    <div class="top_area width_90">
        <h3>Top Areas and Neighborhoods</h3>
        <div class="row">
            <div class="col-md-6"> 
                <ul class="nav">
                    <?php foreach($top_areas as $key=>$city): if($key>7) break;?>
                    <li><a href="{{url('search/?city='.urlencode($city['name']))}}"><span class="badge pull-right">{{$city['total_listing']}}</span>{{$city['name']}} <span class="dot"></span></a></li>
                    <?php endforeach ?>
                </ul>
            </div>
            <div class="col-md-6">
                <ul class="nav">
                    <?php foreach($top_areas as $key=>$city): if($key>7) : ?>
                    <li><a href="{{url('search/?city='.urlencode($city['name']))}}"><span class="badge pull-right">{{$city['total_listing']}}</span>{{$city['name']}} <span class="dot"></span></a></li>
                    <?php endif; endforeach ?>
                </ul>
            </div>
        </div>
       
    </div>
</div>

<div class="container-fluid">
        <div class="popular_listing width_90">
        <!-- polular listing will load after ajax call -->
        <p class="text-center">Loading.....{{HTML::image("assets/img/loading-sm.gif")}}</p>
        </div>

</div>
<script id="template-popular-listing" type="text/x-handlebars-template">
    <h2 class="pull-left">POPULAR LISTINGS</h2>
    {{link_to('search/?sort=popular','See More','class="btn btn-default pull-right see_more"')}}
    <div class="clearfix"></div>
    <div class="row">
    @{{#each data }}
        <div class="col-lg-4 col-md-4 col-sm-4 block-popular">
            <div class="listing">
            @{{#if status_icon}}
                <div class="new_tag_2">
                    <img src="@{{status_icon}}" alt="@{{status}}"/>
                </div>
            @{{/if}}
                                    
            <div class="star_tag">
                @{{#if favorite}}
                <button type="button" class="btn btn-default btn-lg favorites fav"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="true">
                    <span class="glyphicon glyphicon-star"></span>
                </button>
                     @{{else}}
                <button type="button" class="btn btn-default btn-lg favorites"  data-id="@{{listing_id}}"  data-is_signed_in="{{@Auth::check()?'true':'false'}}"  data-fav="false">
                    <span class="glyphicon glyphicon-star"></span>
                </button>
                     @{{/if}}
            </div>
                <div class="listing_img">
                    <img class="img-responsive" src="http://images.primarynational.com/@{{mls_system_id}}/@{{listing_key}}_1.jpg" alt="@{{listing_id}}">
                </div>
                <div class="listing_content">
                    <div class="content_top clearfix">
                        <h5 class="pull-left"><b>@{{street_number}} @{{street_name}} @{{city}}, @{{state}}, @{{zip_code}} </b></h5>
                        <span class="pull-right margin-top-10">@{{formatedPrice}}</span>
                    </div>
                    <p>@{{property_type}} <img class="pull-right" src="@{{mls_logo}}" alt="@{{listing_id}}"></p>
                    <div class="clearfix"></div>
                    <div class="see_details clearfix">
                        <a href="@{{url}}" data-id="@{{listing_id}}" data-lng="@{{longitude}}" data-lat="@{{latitude}}" data-address="@{{street_number}} @{{street_name}}, @{{city}}, @{{state}} @{{zip_code}}" class="btn btn-danger pull-left show_details_listing see_details_btn">See details</a>
                        <span class="pull-right">@{{bedrooms}} BEDS  @{{full_baths}} BATHS  10 ACRES</span>
                    </div>
                </div>
            </div>
        </div>
    @{{/each}}
    </div>
</script>

@stop