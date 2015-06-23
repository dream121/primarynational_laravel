@extends('layouts/default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
    <div class="row">
        <div class="blog_page_header">
            <div class="blog_page_header_content">
                <h1 class="text-center">Real Estate Guides for Primary National</h1>
            </div>
        </div>
        <div class="guides_header">
            <div class="latest_blog">
                <h4 class="text-center">GUIDES</h4>
                <div class="header_design_blog"></div>
            </div>
        </div>

        <div class="guide_breadcrumbs">
            <ol class="breadcrumb">
            @foreach($breadcrumbs as $breadcrumb)
                <li><a href="{{url('community-guides/?'.(Input::has('state') || Input::has('city') ?'city='.urlencode($breadcrumb):'state='.urlencode($breadcrumb)))}}">{{$breadcrumb}}</a></li>
            @endforeach
            </ol>
        </div>
    </div>

    <div class="container-fluid">
        <div class="community_guide">
        @foreach($guides as $guide)
            <div class="col-md-6">
                <div class="community_guide_post">
                    <div class="guide_post_img img-box">
                    @if(!empty($guide->image_link_1))
                        <img class="img-responsive" src="<?=Croppa::url($guide->image_link_1, 235, 200, array('resize'))?>" alt="{{$guide->title}}"/>
                    @endif
                    </div>
                    <div class="blog_context">
                        <div class="blog_post_logo">
                            <img src="{{asset('assets/img/small_logo_blog.jpg')}}"/>
                            <p><span>PRIMARY NATIONAL</span>{{@$guide->state?' / '.$guide->state:''}}{{$guide->city?' / '.$guide->city:''}}</p>
                        </div>
                        <h3>{{link_to('community-guides/'.$guide->slug,$guide->title)}}</h3>
                        <div class="blog_short_brief">
                            {{Str::words(strip_tags($guide->content),50)}}
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
        </div>
    </div>
    <?php echo $guides->links(); ?>

</div>

<div class="subscribe">
@include('blog/blog_footer')
</div>
{{--old--}}


@stop