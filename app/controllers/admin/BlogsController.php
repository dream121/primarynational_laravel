<?php

class BlogsController extends AdminController {

    protected $viewBase = "admin.blog";

    public function __construct(){
        View::share('page_title', 'Manage Blog');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $per_page=Input::has('per_page')?Input::get('per_page'):10;
        $blogs = Blog::paginate($per_page);
        $this->view('index',compact('blogs'));
    }


    public function getCreate()
    {
        $categories = Category::where('type','=','blog')->lists('name', 'id');
        $this->view('create',compact('categories'));
    }

    public function postCreate()
    {
        
        $validator = Validator::make(Input::all(), Blog::rules());
        $destinationPath = public_path().'/photos/blogs/';
        
        if ($validator->passes()) {

            $blog = new Blog;

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }
            
            $img_file = Input::file('image_file');

            if($img_file){
                
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(1200,null,function ($constraint) {
                   // prevent possible upsizing
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $blog->image_link_1       = 'photos/blogs/'.$filename;
            }
			

            $blog->title 				= Input::get('title');
            $blog->content 				= Input::get('content');
            $blog->slug 				= Input::get('slug');
            $blog->status 				= Input::has('status')?Input::get('status'):0;
            $blog->author_id			= Auth::user()->id;
            $blog->category_id          = Input::get('category_id');
            $blog->save();
            if(Input::has('tag'))
                $blog->tags()->sync($this->_getTagIds(Input::get('tag')));

            return Redirect::to('admin/blogs/index')
                ->with('success_msg', 'Blog created successfully');
        }

        return Redirect::to('admin/blogs/create')
            ->with('error_msg', 'Blog has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
    }

    function _getTagIds($data)
    {
        $obTag=new Tag();
        $tag_ids=array();
        if($data)
        {
            $tags_=explode(',',$data);
        }
        foreach($tags_ as $tag)
        {
            $obTag=new Tag();
            $_result=$obTag->getByTitle($tag);
            if($_result)
            {
                $tag_ids[]=$_result[0];
            }
            else
            {
                $obTag->title=$tag;
                $obTag->slug=preg_replace('/[^A-Za-z0-9-]+/', '-', $tag);
                $obTag->save();
                $tag_ids[]=$obTag->id;
            }
        }
        return $tag_ids;
    }
    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    public function getShow($id)
    {
        $blog  = Blog::find($id);
        $comments= $blog->comments;
        $tags = $blog->tags;
        return View::make('admin.blog.show')->with(compact('blog','comments','tags'));
    }

    public function getEdit($id)
    {

        $blog  = Blog::find($id);
        if($blog)
        {
            $tags_ = $blog->tags;
            $tags='';
            $categories = Category::where('type','=','blog')->lists('name', 'id');
            foreach($tags_ as $key=>$tag)
            {
                if($key)
                    $tags.=",".$tag['title'] ;
                else
                    $tags.=$tag['title'] ;
            }
        }
        else
        {
            return Redirect::to('admin/blog/index')
                ->with('error_msg', 'No Record Found.');
        }

        return View::make('admin.blog.edit')->with(compact('blog','tags','categories'));
    }
	
	public function postEdit($id)
    {
		$blog = Blog::find($id);
        $validator = Validator::make(Input::all(), Blog::rules($id));

        $destinationPath = public_path().'/photos/blogs/';
        

        if ($validator->passes()) { 

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, false);
            }
            
            $img_file = Input::file('image_file');

            if($img_file){
                
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(1200,null,function ($constraint) {
                   // prevent possible upsizing
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $blog->image_link_1       = 'photos/blogs/'.$filename;
            }
           


			
            $blog->title 				= Input::get('title');
            $blog->content 				= Input::get('content');
            $blog->slug 				= Input::get('slug');
            $blog->status 				= Input::get('status');
            $blog->author_id			= Auth::user()->id;
            $blog->category_id          = Input::get('category_id');
            $blog->save();
            if(Input::has('tag'))
                $blog->tags()->sync($this->_getTagIds(Input::get('tag')));
            else
                $blog->tags()->detach();
            return Redirect::to('admin/blogs/index')
                ->with('success_msg', 'Blog Updated successfully');
        }

        return Redirect::to('admin/blogs/edit/'.$id)
            ->with('error_msg', 'Blog has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
        
        $blog  = Blog::find($id);
        return View::make('admin.blog.edit')->with(compact('blog'));
    }

    public function getActivate($id,$status='no')
    {
        $blog = Blog::find($id);
        $blog->status = $status==='yes'?1:0;
        $blog->save();

        return Redirect::back()
            ->with('success_msg', 'Blog Updated successfully');
    }

    public function getDelete($id)
    {
		if(Blog::destroy($id))
		{
			return Redirect::to('admin/blogs/index')
                ->with('success_msg', 'Blog Deleted successfully');
		}
		else
		{
			return Redirect::to('admin/blogs/index')
                ->with('error_msg', 'Delete Operation Failed');
		}
	}

    /**
     * Update the specified resource in storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
	public function getApproval($id,$approval=0)
    {
		$comment = Comment::find($id);
		$comment->approved = $approval;
		$comment->save();
		Session::flash('success_msg', 'Approval Update Successfully'); 
		return Response::json(array('message'=>'success','value'=>$approval));
		
	}
	public function getSearch()
    {
		$tag=new Tag();
        if(Input::get('term'))
            $sub_string=Input::get('term');
        $tags = $tag->search($sub_string);
		return Response::json($tags);
		
	}

}
