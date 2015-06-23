@section('assets-js')
@parent
<script>
    var query_type='all';
    $('body').on('click','#filter_all',function(e){
        e.preventDefault();
        query_type='all';
        $('#suggestion_type').html($(this).text()+' <span class="caret">');
    });
    $('body').on('click','#filter_address',function(e){
        e.preventDefault();
        query_type='address';
        $('#suggestion_type').html($(this).text()+' <span class="caret">');
    });
    $('body').on('click','#filter_city',function(e){
        e.preventDefault();
        query_type='city';
        $('#suggestion_type').html($(this).text()+' <span class="caret">');
    });
    $('body').on('click','#filter_zipcode',function(e){
        e.preventDefault();
        query_type='zipcode';
        $('#suggestion_type').html($(this).text()+' <span class="caret">');
    });
    $('body').on('click','#filter_listing',function(e){
        e.preventDefault();
        query_type='listing';
        $('#suggestion_type').html($(this).text()+' <span class="caret">');
    });
// Initialize ajax autocomplete:
    $('#auto_complete').devbridgeAutocomplete({
        serviceUrl: baseurl+'/suggest',
    // lookup: teams,
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
        onSearchStart:function(query){
            query.query_type=query_type;
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
//            $('#selction-ajax').html('You selected: none');
        }
    });

    $("#price_drop_down").click(function(e){
        e.preventDefault();
        $('.btn-group>button').removeClass('hover');
        $(this).toggleClass('hover');
        $(".more").hide();
        $(".more_options").show();
        $(".price_drop").toggle();
        $(".beds_drop").hide();
        $(".baths_drop").hide();
        $(".types_drop").hide();
    });
    $("#types_drop_down").click(function(e){
        e.preventDefault();
        $('.btn-group>button').removeClass('hover');
        $(this).addClass('hover');
        $(".more").hide();
        $(".more_options").show();
        $(".types_drop").toggle();
        $(".beds_drop").hide();
        $(".baths_drop").hide();
        $(".price_drop").hide();
    });
    $("#beds_drop_down").click(function(e){
        e.preventDefault();
        $('.btn-group>button').removeClass('hover');
        $(this).addClass('hover');
        $(".more").hide();
        $(".more_options").show();
        $(".beds_drop").toggle();
        $(".price_drop").hide();
        $(".baths_drop").hide();
        $(".types_drop").hide();
    });
    $("#baths_drop_down").click(function(e){
        e.preventDefault();
        $('.btn-group>button').removeClass('hover');
        $(this).addClass('hover');
        $(".more").hide();
        $(".more_options").show();
        $(".baths_drop").toggle();
        $(".price_drop").hide();
        $(".beds_drop").hide();
        $(".types_drop").hide();
    });

    $(".more_options").click(function(e){
        e.preventDefault();
        $('.btn-group>button').removeClass('hover');
        $(".btn-group div.dropdown-menu").hide();
        $(".more_options").show();
        $(this).hide();
        $(".more").slideToggle(1);
    });
    $(".btn-all-feature").click(function(){
        $(".basic_feature").toggle('fold');
        $(".all_feature").toggle('fold');
        if($(this).text()=='See All Feature')
            $(this).text('See Basic Feature');
        else
            $(this).text('See All Feature');
    });


    $(document).ready(function(){
        var min_price="<?=isset($_GET['min_price'])?$_GET['min_price']:'any'?>";
        var max_price="<?=isset($_GET['max_price'])?$_GET['max_price']:'any'?>";
        $('#min_price').find('option').each(function(){
            if(this.value==min_price){
                $(this).prop('selected',true);
            }

        });
        $('#max_price').find('option').each(function(){
            if(this.value==max_price){
                $(this).prop('selected',true);
            }

        });
    })

//    $("#btn-more-result").click(function(e){
//        e.preventDefault();
//        var all_checkbox=[];
//        $('.more *').filter(':input').each(function(){
//            //your code here
////            console.log($(this));
//            if($(this).attr('type')=='checkbox'){
//                if($(this).is(':checked'))
//                    search_query.features.push($(this).val());
//            }else{
//                if($(this).val().length>0)
//                  search_query[$(this).attr('name')]=$(this).val();
//            }
//        });
//        console.log(search_query);
//    })

</script>
@stop
@include('elements.main_menu')
<?php $beds=isset($_GET['beds'])?$_GET['beds']:'any' ?>
<?php $baths=isset($_GET['baths'])?$_GET['baths']:'any' ?>
<?php $types=isset($_GET['types'])?$_GET['types']:'any' ?>
<div class="container-fluid max_width bg_white">
    <div class="sub_menu">
        <div class="col-md-3 visible-md visible-lg">
            <div class="logo_2">
                <a href="{{url('/')}}"><img src="{{asset('assets/img/logo.jpg')}}" alt="Logo"/></a>
            </div>
        </div>
        <div class="col-md-9">
                <div class="sub_search sub_search_no_top_margin">
                    <form class="clearfix">
                        <div class="all_search">
                            <div class="input-group">
                                <div class="input-group-btn">
                                    <button id="suggestion_type" type="button" class="btn btn-default input-lg dropdown-toggle" data-toggle="dropdown">Search All <span class="caret"></span></button>
                                    <ul class="dropdown-menu" role="menu">
                                        <li><a href="#" id="filter_all">Search All</a></li>
                                        <li><a href="#" id="filter_address">Address</a></li>
                                        <li><a href="#" id="filter_city">City</a></li>
                                        <li><a href="#" id="filter_zipcode">Zip Code</a></li>
                                        <li class="divider"></li>
                                        <li><a href="#" id="filter_listing">Listing</a></li>
                                    </ul>
                                </div>
                                <input id="auto_complete" class="form-control input-lg" name="query" type="text" placeholder="Type any area, address, zip etc" >
                                <div class="input-group-btn">
                                    <button type="button" class="btn btn-default dropdown-toggle input-lg" data-toggle="dropdown" tabindex="-1">
                                    </button>
                                    
                                </div>
                            </div>
                        </div>
                        <div class="search_2_details">
                            
                            <div class="btn-group sub-search">
                                <div class="btn-group dropdown">
                                <button type="button" id="price_drop_down" role="button"  data-toggle="dropdown" class="btn btn-danger btn-lg">Price <span class="caret"></span></button>
                                <div aria-labelledby="price_drop" class="dropdown-menu price_drop price-cs">
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
                                </div>
                                </div>
                                <div class="btn-group">
                                <button id="types_drop_down" role="button"  data-toggle="dropdown" type="button" class="btn btn-danger btn-lg">Type <span class="caret"></span></button>
                                <div class="dropdown-menu types_drop drop2" role="menu" aria-labelledby="types_drop">
                                        
                                            
                                               
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option1" value="any" {{@$types=='any'?'checked':''}}>
                                                            Any
                                                        </label>
                                                    </div>
                                               
                                               
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option2" value="SF" {{@$types=='SF'?'checked':''}}
                                                                   >
                                                            Single Familly
                                                        </label>
                                                    </div>
                                               
                                               
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option3" value="condo" {{@$types=='condo'?'checked':''}}
                                                                   >
                                                            condo
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option4" value="land" {{@$types=='land'?'checked':''}}
                                                                   >
                                                            land
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option5" value="mf" {{@$types=='mf'?'checked':''}}>
                                                            MF
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option6" value="com" {{@$types=='com'?'checked':''}}>
                                                            com
                                                        </label>
                                                    </div>
                                                    <div class="checkbox">
                                                        <label>
                                                            <input class="types_option" type="checkbox" name="types_option7" value="rent" {{@$types=='rent'?'checked':''}}>
                                                            rent
                                                        </label>
                                                    </div>
                                               
                                      
                                    </div>
                                
                                </div>
                                <div class="btn-group">
                                <button id="beds_drop_down" role="button"  data-toggle="dropdown" type="button" class="btn btn-danger btn-lg">Beds <span class="caret"></span></button>
                                    <div class="dropdown-menu beds_drop drop2" role="menu" aria-labelledby="beds_drop">
                                        
                                                    <div class="radio">
                                                        <label>
                                                            <input class="beds" type="radio" name="beds" value="any"
                                                                   {{@$beds=='any'?'checked=""':''}}>
                                                            Any
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="beds" type="radio" name="beds" value="2"
                                                                    {{@$beds==2?'checked':''}}>
                                                            2+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="beds" type="radio" name="beds" value="3"
                                                                    {{@$beds==3?'checked':''}}>
                                                            3+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="beds" type="radio" name="beds" value="4"
                                                                    {{@$beds==4?'checked':''}}>
                                                            4+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="beds" type="radio" name="beds" value="5"
                                                                    {{@$beds==5?'checked':''}}>
                                                            5+
                                                        </label>
                                                    </div>
                                            
                                        
                                    </div>
                                    
                                </div>
                                <div class="btn-group">
                                    <div aria-labelledby="baths_drop" role="menu" class="dropdown-menu drop2 baths_drop">
                                                   <div class="radio">
                                                        <label>
                                                            <input class="baths" type="radio" value="any" name="baths" {{@$baths=='any'?'checked':''}}>
                                                            Any
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="baths" type="radio" value="2" name="baths" {{@$baths==2?'checked':''}}>
                                                            2+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="baths" type="radio" value="3" name="baths" {{@$baths==3?'checked':''}}>
                                                            3+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="baths" type="radio" value="4" name="baths" {{@$baths==4?'checked':''}}>
                                                            4+
                                                        </label>
                                                    </div>
                                                    <div class="radio">
                                                        <label>
                                                            <input class="baths" type="radio" value="5" name="baths" {{@$baths==5?'checked':''}}>
                                                            5+
                                                        </label>
                                                    </div>
                                               
                                    </div>
                                    <button id="baths_drop_down"  type="button" class="btn btn-danger btn-lg" data-toggle="dropdown">Baths <span class="caret"></span></button>
                                </div>
                            </div>
                        </div>
                    </form>

                    <div class="more col-lg-12" style="display:none;position: absolute;background-color: white; z-index: 1000;">
                    <div class="basic_feature">
                        <div class="more_content">
                            <div class="col-md-4">
                                <fieldset class="more_content_left">

                                    <label class="ps-select-label">SqFt</label>

                                    <select class="ps-select js-sqft" name="minsqft" id="minsqft">
                                        <option value="">Any</option>
                                        <option value="500">500</option>
                                        <option value="550">550</option>
                                        <option value="600">600</option>
                                        <option value="650">650</option>
                                        <option value="700">700</option>
                                        <option value="750">750</option>
                                        <option value="800">800</option>
                                        <option value="850">850</option>
                                        <option value="900">900</option>
                                        <option value="950">950</option>
                                        <option value="1000">1,000</option>
                                        <option value="1050">1,050</option>
                                        <option value="1100">1,100</option>
                                        <option value="1150">1,150</option>
                                        <option value="1200">1,200</option>
                                        <option value="1250">1,250</option>
                                        <option value="1500">1,500</option>
                                        <option value="1750">1,750</option>
                                        <option value="2000">2,000</option>
                                        <option value="2250">2,250</option>
                                        <option value="2500">2,500</option>
                                        <option value="2750">2,750</option>
                                        <option value="3000">3,000</option>
                                        <option value="3500">3,500</option>
                                        <option value="4000">4,000</option>
                                        <option value="5000">5,000</option>
                                    </select>

                                    <span class="ps-to-label">to</span>

                                    <select class="ps-select js-sqft" name="maxsqft" id="maxsqft">
                                        <option value="">Any</option>
                                        <option value="500">500</option>
                                        <option value="550">550</option>
                                        <option value="600">600</option>
                                        <option value="650">650</option>
                                        <option value="700">700</option>
                                        <option value="750">750</option>
                                        <option value="800">800</option>
                                        <option value="850">850</option>
                                        <option value="900">900</option>
                                        <option value="950">950</option>
                                        <option value="1000">1,000</option>
                                        <option value="1050">1,050</option>
                                        <option value="1100">1,100</option>
                                        <option value="1150">1,150</option>
                                        <option value="1200">1,200</option>
                                        <option value="1250">1,250</option>
                                        <option value="1500">1,500</option>
                                        <option value="1750">1,750</option>
                                        <option value="2000">2,000</option>
                                        <option value="2250">2,250</option>
                                        <option value="2500">2,500</option>
                                        <option value="2750">2,750</option>
                                        <option value="3000">3,000</option>
                                        <option value="3500">3,500</option>
                                        <option value="4000">4,000</option>
                                        <option value="5000">5,000</option>
                                    </select>

                                    <br>

                                    <label class="ps-select-label">Acres</label>

                                    <select class="ps-select js-acres" name="minacres" id="minacres">
                                        <option value="">Any</option>
                                        <option value="0.01">1/100</option>
                                        <option value="0.15">1/8</option>
                                        <option value="0.25">1/4</option>
                                        <option value="0.5">1/2</option>
                                        <option value="0.75">3/4</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>

                                    <span class="ps-to-label">to</span>

                                    <select class="ps-select js-acres" name="maxacres" id="maxacres">
                                        <option value="">Any</option>
                                        <option value="0.01">1/100</option>
                                        <option value="0.15">1/8</option>
                                        <option value="0.25">1/4</option>
                                        <option value="0.5">1/2</option>
                                        <option value="0.75">3/4</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                        <option value="6">6</option>
                                        <option value="7">7</option>
                                        <option value="8">8</option>
                                        <option value="9">9</option>
                                        <option value="10">10</option>
                                        <option value="20">20</option>
                                        <option value="50">50</option>
                                        <option value="100">100</option>
                                    </select>

                                    <br>

                                    <label class="ps-select-label">Stories</label>

                                    <select id="minstories" name="minstories">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>

                                    <span>to</span>

                                    <select id="maxstories" name="maxstories">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>
                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="more_content_center">
                                    <label class="ps-select-label">Year <span class="ps-hide-smallest">Built</span></label>

                                    <select id="minyearbuilt" name="minyearbuilt">
                                        <option value="">Any</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2000">2000</option>
                                        <option value="1995">1995</option>
                                        <option value="1990">1990</option>
                                        <option value="1980">1980</option>
                                        <option value="1970">1970</option>
                                        <option value="1960">1960</option>
                                        <option value="1950">1950</option>
                                        <option value="1940">1940</option>
                                        <option value="1930">1930</option>
                                        <option value="1920">1920</option>
                                        <option value="1900">1900</option>
                                    </select>

                                    <span>to</span>

                                    <select id="maxyearbuilt" name="maxyearbuilt">
                                        <option value="">Any</option>
                                        <option value="2014">2014</option>
                                        <option value="2013">2013</option>
                                        <option value="2012">2012</option>
                                        <option value="2011">2011</option>
                                        <option value="2010">2010</option>
                                        <option value="2009">2009</option>
                                        <option value="2008">2008</option>
                                        <option value="2007">2007</option>
                                        <option value="2006">2006</option>
                                        <option value="2005">2005</option>
                                        <option value="2000">2000</option>
                                        <option value="1995">1995</option>
                                        <option value="1990">1990</option>
                                        <option value="1980">1980</option>
                                        <option value="1970">1970</option>
                                        <option value="1960">1960</option>
                                        <option value="1950">1950</option>
                                        <option value="1940">1940</option>
                                        <option value="1930">1930</option>
                                        <option value="1920">1920</option>
                                        <option value="1900">1900</option>
                                    </select>

                                    <br>

                                    <label>Garage Spaces</label>

                                    <select id="mingaragespace" name="mingaragespace">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>

                                    <span>to</span>

                                    <select id="maxgaragespace" name="maxgaragespace">
                                        <option value="">Any</option>
                                        <option value="1">1</option>
                                        <option value="2">2</option>
                                        <option value="3">3</option>
                                        <option value="4">4</option>
                                        <option value="5">5</option>
                                    </select>

                                </fieldset>
                            </div>
                            <div class="col-md-4">
                                <fieldset class="more_content_right">

                                    <label># Status</label>

                                    <select id="status" name="status">
                                        <option value="any">Any</option>
                                        @foreach($status_all as $index=>$value)
                                        <option value={{urlencode($index)}}>{{$value}}</option>
                                        @endforeach
                                    </select>

                                    <br>
                                    <label># Days on Site</label>

                                    <select id="dayson" name="dayson">
                                        <option value="any">Any</option>
                                        <option value="1">New Listings (Since Yesterday)</option>
                                        <option value="3">Less than 3 Days</option>
                                        <option value="7">Less than 7 Days</option>
                                        <option value="14">Less than 14 Days</option>
                                        <option value="30">Less than 30 Days</option>
                                        <option value="45">Less than 45 Days</option>
                                        <option value="60">Less than 60 Days</option>
                                    </select>

                                    <br>

                                    {{--<label class="p_hidden">Price Reduced</label>--}}

                                    <select id="pricereduce" name="pricereduce"  class="p_hidden">
                                        <option value="">Any</option>
                                        <option value="&lt;=1">Newest (Since Yesterday)</option>
                                        <option value="&lt;=3">Last 3 Days</option>
                                        <option value="&lt;=7">Less than 7 Days</option>
                                        <option value="&lt;=14">Less than 14 Days</option>
                                        <option value="&lt;=30">Less than 30 Days</option>
                                        <option value="&gt;30">More than 30 Days</option>
                                        <option value="&gt;60">More Than 60 Days</option>
                                        <option value="&gt;120">More than 120</option>
                                    </select>

                                </fieldset>
                            </div>
                        </div>

                        <div class="clearfix"></div>

                        <div class="popular-features">

                            <h4 class="ps-sub-header">Popular Features</h4>

                            <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                                <label title="Has Photos">
                                    <input type="checkbox" value="photo" name="photo">
                                    Has Photos
                                </label>

                                <label title="Open House">
                                    <input type="checkbox" value="OH" name="feature">
                                    Open House
                                </label>

                                <label title="Waterfront" class="p_hidden">
                                    <input type="checkbox" value="W" name="feature">
                                    Waterfront                </label>
                                <label title="New Construction" class="p_hidden">
                                    <input type="checkbox" value="NC" name="feature">
                                    New Construction                </label>
                                <label title="Garage">
                                    <input type="checkbox" value="GR" name="feature">
                                    Garage                </label>
                                <label title="Pool">
                                    <input type="checkbox" value="P" name="feature">
                                    Pool                </label>
                                <label title="Fireplace">
                                    <input type="checkbox" value="F" name="feature">
                                    Fireplace                </label>
                                <label title="Master Downstairs" class="p_hidden">
                                    <input type="checkbox" value="MD" name="feature">
                                    Master Downstairs                </label>
                                <label title="Basement">
                                    <input type="checkbox" value="HBASE" name="feature">
                                    Basement                </label>
                            </fieldset>
                        </div>
                    </div>
                        <div class="all_feature" style="display: none;">

                        <h4 class="ps-sub-header first-of-type">Community Features</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Community Pool" class="p_hidden">
                                <input type="checkbox" value="HCPOOL" name="feature">
                                Community Pool                    </label>
                            <label title="Has HOA" class="p_hidden">
                                <input type="checkbox" value="HOA" name="feature">
                                Has HOA                    </label>
                            <label title="Horse Property" class="p_hidden">
                                <input type="checkbox" value="HP" name="feature">
                                Horse Property                    </label>
                            <label title="Planned Unit Development" class="p_hidden">
                                <input type="checkbox" value="PUD" name="feature">
                                Planned Unit Development                    </label>
                            <label title="Tennis Community">
                                <input type="checkbox" value="TC" name="feature">
                                Tennis Community                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Property Features</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Currently A Rental">
                                <input type="checkbox" value="IRENT" name="feature" class="p_hidden">
                                Currently A Rental                    </label>
                            <label title="Gas Utilities">
                                <input type="checkbox" value="GAS" name="feature" class="p_hidden">
                                Gas Utilities                    </label>
                            <label title="Handicap Equipped">
                                <input type="checkbox" value="HC" name="feature">
                                Handicap Equipped                    </label>
                            <label title="Historic Property">
                                <input type="checkbox" value="H" name="feature">
                                Historic Property                    </label>
                            <label title="InLaw Suite">
                                <input type="checkbox" value="HMTIL" name="feature" class="p_hidden">
                                InLaw Suite                    </label>
                            <label title="New Construction">
                                <input type="checkbox" value="NC" name="feature" class="p_hidden">
                                New Construction                    </label>
                            <label title="On Golf Course">
                                <input type="checkbox" value="GC" name="feature">
                                On Golf Course                    </label>
                            <label title="Public Water" class="p_hidden">
                                <input type="checkbox" value="IPW" name="feature">
                                Public Water                    </label>
                            <label title="Septic">
                                <input type="checkbox" value="ISP" name="feature">
                                Septic                    </label>
                            <label title="Sewer">
                                <input type="checkbox" value="IS" name="feature">
                                Sewer                    </label>
                            <label title="Underground Utilities" class="p_hidden">
                                <input type="checkbox" value="UU" name="feature">
                                Underground Utilities                    </label>
                            <label title="Well" class="p_hidden">
                                <input type="checkbox" value="IW" name="feature">
                                Well                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Waterfront</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Waterfront" class="p_hidden">
                                <input type="checkbox" value="W" name="feature">
                                Waterfront                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Exterior Features</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Brick Construction" class="p_hidden">
                                <input type="checkbox" value="BRC" name="feature">
                                Brick Construction                    </label>
                            <label title="Carport" class="p_hidden">
                                <input type="checkbox" value="HCARP" name="feature">
                                Carport                    </label>
                            <label title="Deck">
                                <input type="checkbox" value="HD" name="feature">
                                Deck                    </label>
                            <label title="Fenced Yard">
                                <input type="checkbox" value="ISFENCE" name="feature">
                                Fenced Yard                    </label>
                            <label title="Garage">
                                <input type="checkbox" value="GR" name="feature">
                                Garage                    </label>
                            <label title="Garage - Attached">
                                <input type="checkbox" value="HAG" name="feature">
                                Garage - Attached                    </label>
                            <label title="Garage - Detached">
                                <input type="checkbox" value="HDC" name="feature">
                                Garage - Detached                    </label>
                            <label title="Hot Tub">
                                <input type="checkbox" value="HHT" name="feature">
                                Hot Tub                    </label>
                            <label title="Parking - Off-Street">
                                <input type="checkbox" value="HOFSP" name="feature">
                                Parking - Off-Street                    </label>
                            <label title="Patio">
                                <input type="checkbox" value="HPTO" name="feature">
                                Patio                    </label>
                            <label title="Pool">
                                <input type="checkbox" value="P" name="feature">
                                Pool                    </label>
                            <label title="Pool - Above Ground">
                                <input type="checkbox" value="HPAGP" name="feature">
                                Pool - Above Ground                    </label>
                            <label title="Pool - Below Ground">
                                <input type="checkbox" value="HPIGP" name="feature">
                                Pool - Below Ground                    </label>
                            <label title="Sprinkler System">
                                <input type="checkbox" value="HSS" name="feature">
                                Sprinkler System                    </label>
                            <label title="Storage Buildings">
                                <input type="checkbox" value="HSB" name="feature">
                                Storage Buildings                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Interior Features</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Air Conditioning">
                                <input type="checkbox" value="HAC" name="feature">
                                Air Conditioning                    </label>
                            <label title="Basement">
                                <input type="checkbox" value="HBASE" name="feature">
                                Basement                    </label>
                            <label title="Basement - Finished">
                                <input type="checkbox" value="HFBASE" name="feature">
                                Basement - Finished                    </label>
                            <label title="Basement - Partially Finished">
                                <input type="checkbox" value="HPFB" name="feature">
                                Basement - Partially Finished                    </label>
                            <label title="Basement - Unfinished">
                                <input type="checkbox" value="HUFBASE" name="feature">
                                Basement - Unfinished                    </label>
                            <label title="Basement - Walk-Out">
                                <input type="checkbox" value="HWOB" name="feature">
                                Basement - Walk-Out                    </label>
                            <label title="Bonus Room" class="p_hidden">
                                <input type="checkbox" value="BNROM" name="feature">
                                Bonus Room                    </label>
                            <label title="Carpet Floors">
                                <input type="checkbox" value="CPTFL" name="feature">
                                Carpet Floors                    </label>
                            <label title="Elevator">
                                <input type="checkbox" value="HE" name="feature">
                                Elevator                    </label>
                            <label title="Fireplace">
                                <input type="checkbox" value="F" name="feature">
                                Fireplace                    </label>
                            <label title="Formal Dining" class="p_hidden">
                                <input type="checkbox" value="FRMD" name="feature">
                                Formal Dining                    </label>
                            <label title="Great Room" class="p_hidden">
                                <input type="checkbox" value="GRM" name="feature">
                                Great Room                    </label>
                            <label title="Hardwood Floors">
                                <input type="checkbox" value="HHF" name="feature">
                                Hardwood Floors                    </label>
                            <label title="Heat - Electric">
                                <input type="checkbox" value="HEATE" name="feature">
                                Heat - Electric                    </label>
                            <label title="Laundry Hookup" class="p_hidden">
                                <input type="checkbox" value="LAUND" name="feature">
                                Laundry Hookup                    </label>
                            <label title="Main Floor Bedroom" class="p_hidden">
                                <input type="checkbox" value="HMFB" name="feature">
                                Main Floor Bedroom                    </label>
                            <label title="Master Downstairs" class="p_hidden">
                                <input type="checkbox" value="MD" name="feature">
                                Master Downstairs                    </label>
                            <label title="No Basement">
                                <input type="checkbox" value="HNB" name="feature">
                                No Basement                    </label>
                            <label title="Tile Floors" class="p_hidden">
                                <input type="checkbox" value="TLF" name="feature">
                                Tile Floors                    </label>
                            <label title="Walk-In Closet" class="p_hidden">
                                <input type="checkbox" value="HWIC" name="feature">
                                Walk-In Closet                    </label>
                            <label title="Washer / Dryer In Unit">
                                <input type="checkbox" value="WD" name="feature">
                                Washer / Dryer In Unit                    </label>
                            <label title="Wet Bar">
                                <input type="checkbox" value="HWB" name="feature">
                                Wet Bar                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Style</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Contemporary">
                                <input type="checkbox" value="CT" name="feature">
                                Contemporary                    </label>
                            <label title="Log / Log Look" class="p_hidden">
                                <input type="checkbox" value="ILOLL" name="feature">
                                Log / Log Look                    </label>
                        </fieldset>
                        <h4 class="ps-sub-header first-of-type">Financing</h4>
                        <fieldset class="powersearch-checkbox-set wrapped-checkbox-set wrapped-input-set ps-fieldset">

                            <label title="Lease Option" class="p_hidden">
                                <input type="checkbox" value="LO" name="feature">
                                Lease Option                    </label>
                            <label title="Owner Financing" class="p_hidden">
                                <input type="checkbox" value="IOWNF" name="feature">
                                Owner Financing                    </label>
                        </fieldset>
                        </div>

                        <div class="more_footer">
                            <a class="btn btn-default btn-lg pull-left btn-all-feature" href="#">See All Feature</a>
                            <a class="btn btn-danger btn-lg pull-right" href="#" id="btn-more-result"> Results</a>
                        </div>
                        <a href="#" class="more_options">Close Options &gt;&gt;</a>
                    </div>
                    <a href="#" class="more_options">More Options &gt;&gt;</a>
                    <div class="sub_search_nav">
                        <div class="short_by">
                            <select class="form-control" name="sort" id="sort_by">
                                <option>Sort By</option>
                                <option value="listprice">Price (Highest)</option>
                                <option value="listprice_asc">Price (Lowest)</option>
                                <option value="popular">Most Popular</option>
                                <option value="bedrooms">Bedrooms (Most)</option>
                                <option value="fullbaths">Bathrooms (Most)</option>
                                <option value="acerage_dsc">Acreage (Highest)</option>
                                <option value="acerage_asc">Acreage (Lowest)</option>
                                <option value="yearbuilt">Year Built (Newest)</option>
                                <option value="yearbuilt_asc">Year Built (Oldest)</option>
                                <option value="imported">Days on Site (Newest)</option>
                                <option value="imported_asc">Days on Site (Oldest)</option>
                            </select>
                        </div>
                        <div class="sub_search_nav_btn">
                            <div class="btn-group">
                            {{--<a href="{{url('search/map/?'.$uri)}}"  class="map-link btn btn-default {{$sub_menu=='map'?'active':''}}"><span class="glyphicon glyphicon-map-marker"></span>--}}
                                {{--Map--}}
                            {{--</a>--}}
                            <a href="{{url('search/?'.$uri)}}" class="map-link btn btn-default {{$sub_menu=='photo'?'active':''}}"><span class="glyphicon glyphicon-picture"></span>
                                Photos
                            </a>
                            <a  href="{{url('search/gallery/?'.$uri)}}" class="map-link btn btn-default {{$sub_menu=='gallery'?'active':''}}"><span class="glyphicon glyphicon-th-large"></span>
                                Gallery
                            </a>
                        </div>
                        </div>
                    </div>
                </div>
            </div>
        <div class="clearfix"></div>
    </div>
    <div class="separator">
        <img class="img-responsive" src="{{asset('assets/img/seperator.png')}}"/>
    </div>
</div>