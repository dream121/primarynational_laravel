@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
    <div class="row">
        <div class="blog_details_header" {{@$guide->image_link_1?"style='background: url(".asset($guide->image_link_1).") no-repeat;background-size: 100% auto;'":""}}>
            <div class="bd_bg_opacity">
                <h1>{{$guide->title}}</h1>
                <p>{{Str::words(strip_tags($guide->content),25)}}</p>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="communuty_details_wrapper">
                    {{--<div class="cgd_header">--}}
                        {{--<h6 class="text-muted">BUYER'S GUIDE FIRST STEPS</h6>--}}
                        {{--<h3>Owning vs. Renting a Home</h3>--}}
                    {{--</div>--}}

                    <div class="cgd_banner">
                        <h2>{{$guide->title}}</h2>
                    </div>
                    <div class="img-box">
                        {{@!empty($guide->image_link_1)?"<img alt='' src='".asset($guide->image_link_1)."'/>":''}}
                    </div>
                    <div style="padding-top: 20px;">
                        {{$guide->content}}
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                @include('community_guide/guide_sidebar')
            </div>
            <div class="clearfix"></div>
            <div class="container-fluid">
                <div class="afford">
                    <div class="afford_header text-right">
                        <h4>{{link_to('community-guides/'.$guide->slug.'?state='.$guide->state,$guide->state)}}</h4>
                    </div>

                    <div class="row">
                    @foreach($similer_guides as $s_guide)
                        <div class="col-md-4">
                            <div class="afford_content">
                                <h4>{{link_to('community-guides/'.$s_guide->slug,$s_guide->title)}}</h4>
                                {{Str::words(strip_tags($s_guide->content),25)}}
                            </div>
                        </div>
                    @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
{{--old--}}
</div>
<div class="subscribe">
@include('blog/blog_footer')
</div>
@stop