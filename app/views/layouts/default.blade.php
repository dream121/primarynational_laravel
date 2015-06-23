<!DOCTYPE html>
<html lang="en">
<head>
    <title>{{$title}}</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=EmulateIE10,chrome=1">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!--<link href='http://fonts.googleapis.com/css?family=PT+Sans' rel='stylesheet' type='text/css'>-->
    <!--<link href='http://fonts.googleapis.com/css?family=Open+Sans:400italic,400,300,700,800' rel='stylesheet' type='text/css'>-->
    @section('assets-css')
    {{ HTML::style('assets/css/bootstrap.min.css') }}
    {{ HTML::style('assets/css/flexslider.css') }}
    {{ HTML::style('assets/css/style.css') }}
    {{ HTML::style('assets/css/others.css') }}
    {{ HTML::style('http://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/css/datepicker3.min.css') }} 
    @show
    <script>
        var baseurl = "{{url()}}";
        var loader_img = '{{HTML::image("assets/img/loading-sm.gif")}}';
        var favorites={};
        var is_logged_in = parseInt("{{Auth::check()?1:0}}");
        var client_ip = "{{Request::getClientIp(true)}}";
        var more_details_limit = 300;
        {{--var more_details_counter = parseInt("{{Session::get('more_details_counter',0)}}");--}}
        var more_details_counter=0;

        function keep_history(data)
        {
            if(data)
            {
                console.log(data);
                var recursiveDecoded = $.param( data);
                var url=window.location.href;
                url=url.split("?")[0].split("#")[0];
                url+='?'+recursiveDecoded;
                url_update(recursiveDecoded);
                console.log(recursiveDecoded);
                History.pushState(data,'',url); // logs {state:1}, "State 1", "?state=1"


            }

        }

        function url_update(recursiveDecoded){
            $(".map-link").each(function(){
                var url=$(this).prop('href');
                url=url.split("?")[0].split("#")[0];
                $(this).prop('href',url+'?'+recursiveDecoded);
            })
        }

    </script>
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body>
<div class="max_width">
    <div class="navbar-fixed-top">
    @include($main_menu)
    </div>
    @yield('content')
    @include($main_footer)
</div>
@section('assets-js')
{{ HTML::script('assets/js/jquery-1.10.2.js') }}
{{ HTML::script('assets/js/jQuery.print.js') }}
{{ HTML::script('assets/js/jquery.lazyload.min.js') }}
{{ HTML::script('assets/js/bootstrap.min.js') }}
{{ HTML::script('assets/js/jquery.scrollTo.min.js') }}
<script type="text/javascript" src="//cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.3.0/js/bootstrap-datepicker.min.js"></script>
{{ HTML::script('assets/js/jquery.validate.min.js') }}
{{ HTML::script('assets/js/jquery-validate.bootstrap-tooltip.min.js') }}
{{ HTML::script('assets/js/jquery.flexslider-min.js') }}
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js"></script>
{{ HTML::script('assets/js/handlebars.min.js') }}
{{ HTML::script('assets/js/jquery.autocomplete.js') }}
{{ HTML::script('assets/js/gmap3.infobox.js') }}
{{ HTML::script('assets/js/app.js') }}
{{ HTML::script('assets/js/common.js') }}
{{ HTML::script('assets/js/history/jquery.history.js') }}
{{ HTML::script('assets/js/jquery.cookie.js') }}
@show
@include('elements/modal')
</body>
</html>