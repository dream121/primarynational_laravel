<div class="recent_story">
    <div class="latest_blog">
        <h4 class="text-center">RECENT STORIES</h4>
        <div class="header_design_blog"></div>
    </div>
    @foreach($recent_blogs as $post)
    <div class="recent_story_post" style='background:url("{{URL::asset('assets/img/recent_mark_icon.png')}}") no-repeat scroll left 4px rgba(0, 0, 0, 0)'>
        <p>{{link_to('community-guides/'.$post->slug,$post->title)}}</p>
    </div>
    @endforeach
    {{--<div class="load_more"><a href="#"><img src="{{URL::asset('assets/img/recent_story_load.png')}}" alt=""/></a></div>--}}
</div>

{{--<div class="most_shared">--}}
    {{--<div class="latest_blog">--}}
        {{--<h4 class="text-center">POPULAR STORIES</h4>--}}
        {{--<div class="header_design_blog"></div>--}}
    {{--</div>--}}
    {{--@foreach($popular_blog as $p_blog)--}}
    {{--<div class="most_shared_post">--}}
        {{--<h5><a href="#">{{@$p_blog->title}}</a></h5>--}}
        {{--<div class="social_share">--}}
            {{--<a href="#"><img src="img/most_shared_fb.png"/></a>--}}
            {{--<a href="#"><p>123</p></a>--}}
        {{--</div>--}}
        {{--<div class="social_share">--}}
            {{--<a href="#"><img src="img/most_shared_fb.png"/></a>--}}
            {{--<a href="#"><p>123</p></a>--}}
        {{--</div>--}}
        {{--<div class="social_share">--}}
            {{--<a href="#"><img src="img/most_shared_fb.png"/></a>--}}
            {{--<a href="#"><p>123</p></a>--}}
        {{--</div>--}}
    {{--</div>--}}
    {{--@endforeach--}}

    {{--<div class="load_more"><a href="#"><img src="img/recent_story_load.png" alt=""/></a></div>--}}
{{--</div>--}}