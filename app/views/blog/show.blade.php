@extends('layouts.default')
@section('content')
<div class="container-fluid margin_top_after_sub_menu bg_white">

    <div class="row">
        <div class="blog_details_header" {{@$item->image_link_1?"style='background: url(".asset($item->image_link_1).") no-repeat;background-size: 100% auto;'":""}}>
            <div class="bd_bg_opacity"><h1>{{$item->title}}</h1></div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-9">
                <div class="blog_details_wrapper">
                    <div class="blog_post_logo">
                        <img src="{{asset('assets/img/small_logo_blog.jpg')}}">
                        <p><span>PRIMARY NATIONAL</span></p>
                    </div>
                    <div class="post_meta">
                        By
                        <span><a href="#">{{@$item->user->first_name}} {{@$item->user->last_name}}</a></span>
                        on
                        <strong>{{date("d M Y",strtotime($item->created_at))}}</strong>
                    </div>
                    <div class="img-box">
                        {{@!empty($item->image_link_1)?"<img alt='' src='".asset($item->image_link_1)."'/>":''}}
                    </div>
                    <div class="header">
                        <h3><span></span></h3>
                    </div>
                    {{$item->content}}
                </div>
            </div>

            <div class="col-md-3">
                @include('blog/blog_sidebar')
            </div>
            <div class="clearfix"></div>
            <div class="container-fluid">
                <div class="related">
                    <h3><span>Related:</span></h3>
                    <ul>
                    @foreach($similar_blog as $row)
                         <li>{{ HTML::linkAction('BlogController@getShow',$row->title,array($row->slug)) }}</li>
                    @endforeach
                    </ul>
                </div>

                <div class="about_author">
                    <h3>About the Author</h3>
                    <div class="auth_img">
                        <div class="col-lg-1 img-box">
                            <img src="{{asset(@$item->user->profile->photo?$item->user->profile->photo:'assets/img/comments_user.png')}}"/>
                        </div>

                        <div class="author_text">
                            <h4>{{@$item->user->first_name}} {{@$item->user->last_name}}</h4>
                            <p>{{@$item->user->first_name}} {{@$item->user->last_name}} writes about real estate trends and data for Primary National Blog.</p>
                        </div>
                        <div class="clearfix"></div>
                    </div>
                </div>

                <div class="comments">
                    <h4>{{count($item->comments)}} Comments</h4>
                    {{ Form::open(array('role'=>"form",'files'=>true,'id'=>'comment_form','class'=>'form-horizontal')) }}

                        <div class="form-group">
                            <div class="col-sm-1">
                                <img src="{{asset('assets/img/comments_user.png')}}" alt=""/>
                            </div>
                            <div class="col-sm-11">
                                <textarea id="comment" name="comment" class="form-control" cols="10" rows="4" placeholder="Your Message"></textarea>
                            </div>
                        </div>
                        @if(!Auth::check())
                        <div class="form-group">
                            <div class="col-sm-11 col-sm-offset-1">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <input type="text" id="author_name" name="author_name" class="form-control" placeholder="Name">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="email" id="author_email" name="author_email" class="form-control" placeholder="Email">
                                    </div>
                                    <div class="col-sm-4">
                                        <input type="text" id="phone_no" name="phone_no" class="form-control" placeholder="Phone">
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="form-group">
                            <div class="col-sm-11 col-sm-offset-1">
                                <button class="btn btn-danger" id="blog_comment_submit">SUBMIT COMMENT</button>
                            </div>
                        </div>
                    {{ Form::close() }}
                    <div class="panel-group discussion" id="accordion" role="tablist" aria-multiselectable="true">
                        <div class="panel panel-default">
                            <div class="panel-heading" role="tab" id="headingOne">
                                <h3 class="panel-title">
                                    <a data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                                        Discussion
                                        <span class="caret"></span>
                                    </a>
                                </h3>
                            </div>
                            <div id="collapseOne" class="panel-collapse collapse in" role="tabpanel" aria-labelledby="headingOne">
                                <div class="panel-body">
                                    <div class="user_cmnts">
                                    @foreach($item->comments as $comment)
                                        <div class="user_cmnts_content">
                                            <div class="img-box" style="width:4%;">
                                                <img src="{{@isset($comment->user->profile->photo)?url($comment->user->profile->photo):asset('assets/img/comments_user.png')}}"  alt='' />
                                            </div>
                                            <div class="user_text">
                                                <h5>{{$comment->author_name}} <span>• {{date_diff(new DateTime(), $comment->created_at)->format('%a')>1?(date_diff(new DateTime(), $comment->created_at)->format('%a').' days ago'): (date_diff(new DateTime(), $comment->created_at)->format('%a')==1?'Yesterday':'Today')}}</span></h5>
                                                <p>{{$comment->comment}}</p>
                                            </div>
                                        </div>
                                    @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
        <div class="also_on">
            <h3>Also On Primary National Blog</h3>
            <?php $i=1;?>
            @foreach($recent_blogs as $key=>$recent_blog)
                @if($recent_blog->id !=$item->id)
                    @if($i%2 != 0)

                        <div class="row">
                    <div class="col-md-5 also_content">
                        <h4><a href="{{url('blog/'.$recent_blog->slug)}}">{{$recent_blog->title}}</a></h4>
                        <p>{{count($recent_blog->comments)?count($recent_blog->comments):'0'}} Comments <span>•</span> {{date_diff(new DateTime(), $recent_blog->created_at)->format('%a')}} Days</p>
                        <div class="also_img_text">
                            {{@!empty($recent_blog->image_link_1)?"<img alt='' src='".asset($recent_blog->image_link_1)."'/>":''}}
                            {{Str::words(strip_tags($recent_blog->content),50)}}
                            <div class="clearfix"></div>
                        </div>
                    </div>
                    @else
                    <div class="col-md-5 col-md-offset-2 also_content">
                        <h4><a href="{{url('blog/'.$recent_blog->slug)}}">{{$recent_blog->title}}</a></h4>
                        <p>{{count($recent_blog->comments)?count($recent_blog->comments):'0'}} Comments <span>•</span> {{date_diff(new DateTime(), $recent_blog->created_at)->format('%a')}} Days</p>
                        <div class="also_img_text">
                            {{@!empty($recent_blog->image_link_1)?"<img alt='' src='".asset($recent_blog->image_link_1)."'/>":''}}
                            {{Str::words(strip_tags($recent_blog->content),50)}}
                            <div class="clearfix"></div>
                        </div>
                    </div>

                        </div>
                    @endif
                <?php $i++;?>
                @endif
            @endforeach
        </div>
        <div class="also_like">
            <h3>You Might Also Like</h3>
            <div class="row">
            @foreach($popular_blog as $p_blog)
                <div class="col-md-3">
                    <div class="also_like_content">
                        {{@!empty($p_blog->image_link_1)?"<img alt='' class='img' src='".asset($p_blog->image_link_1)."'/>":''}}
                        <div class="also_like_content">
                            <div class="blog_post_logo">
                                <img alt="" src="{{asset('assets/img/small_logo_blog.jpg')}}">
                                <p><span>PRIMARY NATIONAL</span>  {{@$p_blog->category->name?"/ ".$p_blog->category->name:''}}</p>
                            </div>
                            <h4><a href="{{url('blog/'.$p_blog->slug)}}">{{@$p_blog->title}}</a></h4>
                            <div class="blog_author">
                                <p class="text-muted">BY <span>{{@$p_blog->user->first_name}} {{@$p_blog->user->last_name}}</span> ON <strong>{{date("d M Y",strtotime($p_blog->created_at))}}</strong></p>
                            </div>
                            <div class="blog_short_brief">
                                {{Str::words(strip_tags(@$p_blog->content),50)}}
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</div>
<div class="subscribe">
@include('blog/blog_footer')
</div>
@stop