@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">
    <div class="row">
        <div class="blog_page_header text-center">
        <div class="blog_page_header_content">
            <h1 class="text-center">Heading will come here</h1>
            <h2 class="text-center">The Subheading Will Come Here</h2>
            <button id="subscribe_top" class="btn text-center">SUBSCRIBE NOW</button>
            <div class="clearfix"></div>
            <span id="subscribe_message" style="color:#ffff00"></span>
        </div>

        </div>
        <div class="latest_blog">
            <h4 class="text-center">LATEST STORIES</h4>
            <div class="header_design_blog"></div>
        </div>
        <div class="container-fluid">
            <div class="col-md-9">
            @foreach($blog as $item)
                <div class="latest_blog_post">
                    <div class="blog_img">
                    @if($item->image_link_1)
                    <div class="img-box">
                        <img class="img-responsive" src="<?=Croppa::url($item->image_link_1, 235, 200, array('resize'))?>" alt="{{$item->title}}"/>
                    </div>
                    @endif
                    </div>
                    <div class="blog_context">
                        <div class="blog_post_logo">
                            <img src="{{asset('assets/img/small_logo_blog.jpg')}}"/>
                            <p><span>PRIMARY NATIONAL</span> {{@$item->category->name?'/ '.$item->category->name:''}}</p>
                        </div>
                        <h3><a href="blog/{{$item->slug}}">{{$item->title}}</a></h3>
                        <div class="blog_author">
                            <p class="text-muted">BY <span>{{$item->User->first_name}} {{$item->User->last_name}}</span> ON <strong>{{date_format($item->created_at,'d M Y')}}</strong></p>
                        </div>
                        <div class="blog_short_brief">
                            {{Str::words(strip_tags($item->content),50)}}
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
            <div class="col-md-3">
                @include('blog/blog_sidebar')
            </div>
            <div class="clearfix"></div>
            <div class="navigation">

                @if($blog->getCurrentPage()-1 !=0)
                <a href="{{URL::action('BlogController@getIndex', array('page'=>$blog->getCurrentPage()-1))}}" class="prev">< Previous</a>
                @endif
                @if($blog->getLastPage()==$blog->getCurrentPage()+1)
                <a href="{{URL::action('BlogController@getIndex', array('page'=>$blog->getCurrentPage()+1))}}" class="next">Next ></a>
                @endif
            </div>
        </div>
        <div class="subscribe">
        @include('blog/blog_footer')
        </div>
    </div>
</div>

@stop
