<?php

class BlogController extends FrontendController {

    public function __construct(){

        parent::__construct();
        $this->setTitle('Blog');
        $this->selectMenu('blog');
        $this->setMenu('main_menu_ext_with_sub');
        $social_media = SocialMedia::all();
        $blog_archives = Blog::getBlogArchive();
        View::share(compact('social_media'));
        View::share(compact('blog_archives'));

    }

    public function getIndex()
    {
        $blog = Blog::getAll();
        $recent_blogs = Blog::getRecent();
        $popular_blog = Blog::getPopularBlog();
        View::share(compact('recent_blogs'));
        View::share(compact('popular_blog'));

        return View::make('blog.index')->with(compact('blog'));

    }

    public function getShow($slug){

        $item = Blog::getBlogBySlug($slug);
        $item->hit_count = (int)$item->hit_count+1;
        $item->save();
        $similar_blog = Blog::getBlogByCategory($item->category_id,$item->id);
        $recent_blogs = Blog::getRecent($item->id);
        $popular_blog = Blog::getPopularBlog($item->id);
        View::share(compact('recent_blogs'));
        View::share(compact('popular_blog'));
        View::share(compact('similar_blog'));
        return View::make('blog.show')->with(compact('item'));

    }

    public function getBlogArchive(){
        $querystringArray = array('month'=>Input::get('month'));
        $blog = Blog::getBlogByMonth(Input::get('month'));
        $blog->appends($querystringArray);
        return View::make('blog.index')->with(compact('blog'));
    }

    public function postComment($slug){

        $blog = Blog::getBlogBySlug($slug);
        $inputs=Input::all();
        if(Auth::check()){
            $inputs['author_name']=Auth::user()->first_name." ".Auth::user()->last_name;
            $inputs['author_email']=Auth::user()->email;
            $inputs['phone_no']=Auth::user()->phone_number;
            $inputs['user_id']=Auth::user()->id;
        }
        $validator = Validator::make($inputs, Comment::rules());
        if ($validator->passes()) {
            $comments= new Comment($inputs);
            $blog->comments()->save($comments);
//          email to admin
            $cred['data']= $inputs;
            $cred['data']['blog_slug']= $slug;
            $cred['to'] = Config::get('mail.username');
            $cred['subject'] = $inputs['author_name']."has made a comment";
            $cred['view'] = "emails.blog.comment";
            $this->_sendEmail($cred);

            if(Request::ajax())
                return Response::json(array('success' => true,'message'=>'Comment Sent Successfully'), 200);
            else
                return Redirect::to('blog/'.$slug)
                ->with('success_msg', 'Comments Added Successfully');
        }else{

            if(Request::ajax())
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->errors()->toArray(),
                    'message' => 'Comment Could not Sent',

                ), 200);
            else
                return Redirect::back()->with('error_msg', 'Comment Could not Sent. Please try again!!!')->withErrors($validator);
        }
    }
    public function postSubscribe(){
        $inputs=Input::all();
        if(Auth::check()){
            $inputs['email']=isset($inputs['email'])?$inputs['email']:Auth::user()->email;
        }
        $validator = Validator::make($inputs, Subscriber::rules());
//        $inputs=Input::all();
        if ($validator->passes()) {
            $subscribe=Subscriber::where('email','=',$inputs['email'])->where('type','=','blog')->where('status','=',1)->first();
            if(!$subscribe)
                $subscribe= new Subscriber();

            $subscribe->email=$inputs['email'];
            $subscribe->type='blog';
            $subscribe->status=true;
            $subscribe->save();
            if(Request::ajax())
                return Response::json(array('success' => true,'message'=>'Subscription Successful'), 200);
            else
                return Redirect::back()->with('success_msg', 'Subscription Successful');
        }else{
            if(Request::ajax())
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->errors()->toArray(),
                    'message' => 'Could not Subscribed',

                ), 200);
            else
                return Redirect::back()->with('error_msg', 'Could not Subscribed. Please try again!!!')->withErrors($validator);
        }
    }

}