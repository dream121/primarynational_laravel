<div class="blog_recent_post">
    <h2>Recent post</h2>
    @foreach($recent_blogs as $post)
    <div class="blog_recent_content">
        <div class="row">
            @if($post->image_link_1)
            <div class="col-md-4">
                <img class="img-responsive" src="{{$post->image_link_1}}" alt="{{$post->title}}"/>
            </div>
            @endif
            <div class="col-md-8">
                <p>{{link_to('blog/'.$post->slug,$post->title)}}</p>
                <span class="color_light">posted on {{date("M d, Y",strtotime($post->created_at))}}</span>
            </div>
        </div>

    </div>
    @endforeach
</div>

<div class="archive">
    <h2>Archives</h2>
    <ul class="list-unstyled">
        @foreach($blog_archives as $blog_archive)
        <li><a href="{{action('BlogController@getBlogArchive', array('month'=>$blog_archive->month))}}">{{$blog_archive->month}}</a></li>
        @endforeach
    </ul>
</div>