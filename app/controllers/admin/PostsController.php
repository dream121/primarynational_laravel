<?php

class PostsController extends AdminController {

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
        $posts = Post::paginate(30);
        return View::make('posts.index')->with(compact('posts'));
    }


    public function getCreate()
    {
        return View::make('posts.create');
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), Post::$rules);

        $destinationPath = public_path().'/photos/';

        if ($validator->passes()) {

            $post = new Post;

            for($i=1;$i<5;$i++){

                $file = Input::file('image_link_'.$i);

                if($file){

                    $filename 		= preg_replace('/[^A-Za-z0-9_\-]./', '_', $file->getClientOriginalName());
                    $uploadSuccess 	= $file->move($destinationPath, $filename);

                    if($uploadSuccess){
                        $img_n = 'image_link_'.$i;
                        $post->$img_n			= $filename;
                    }
                }

            }


            $post->title 				= Input::get('title');
            $post->content 				= Input::get('content');
            $post->slug 				= Input::get('slug');
            //$post->war_type_description 	= Input::get('war_type_description');


            $post->save();

            return Redirect::to('admin/blog/index')
                ->with('success_msg', 'Page created successfully');
        }

        return Redirect::to('admin/blog/create')
            ->with('error_msg', 'War data could not be saved!! Something wrong!!')
            ->withErrors($validator)
            ->withInput();
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
        $post  = Post::find($id);
        return View::make('posts.show')->with(compact('post'));
    }



    public function getEdit($id)
    {

        $post  = Post::find($id);
        return View::make('posts.edit')->with(compact('post'));
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


}
