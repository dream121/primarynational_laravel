<?php

class BannerController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Banner');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $banner = Banner::paginate(30);
        return View::make('admin.banner.index')->with(compact('banner'));
    }


    public function getCreate()
    {
        return View::make('admin.banner.create');
    }

    public function postCreate()
    {
        ini_set('memory_limit','256M');
        $validator = Validator::make(Input::all(), Banner::rules());

        $destinationPath = public_path().'/photos/banner/';
        
        if ($validator->passes()) {

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }

            $banner = new Banner;

            $img_file = Input::file('image_file');

            if($img_file){
                $filename      = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                Image::make($img_file)->crop(1800, 900,0,0)->save($destinationPath.$filename); 
                $banner->image_link_1       = 'photos/banner/'.$filename;
             }
            
            $banner->title 				= Input::get('title');
            $banner->slug 				= Input::get('slug');
            $banner->link 				= Input::get('link');
            $banner->status 			= Input::has('status')?Input::get('status'):0;
            $banner->author_id			= Auth::user()->id;
          
            $banner->save();

            return Redirect::to('admin/banner/index')
                ->with('success_msg', 'Banner created successfully');
        }

        return Redirect::to('admin/banner/create')
            ->with('error_msg', 'There are someting wrong!! Please check your inputs again')
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
        $banner  = Banner::find($id);
        //$author = $banner->author();
        return View::make('admin.banner.show')->with(compact('banner'));
    }


    public function getEdit($id)
    {

        $banner  = Banner::find($id);
        return View::make('admin.banner.edit')->with(compact('banner'));
    }
	
	public function postEdit($id)
    {
        ini_set('memory_limit','256M');
		$banner = Banner::find($id);
        
        $validator = Validator::make(Input::all(), Banner::rules($id));

        $destinationPath = public_path().'/photos/banner/';

        if ($validator->passes()) {
            
            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }
			
            $img_file = Input::file('image_file_next');

            if($img_file){
                $filename      = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                Image::make($img_file)->crop(1800, 900,0,0)->save($destinationPath.$filename); 
                $banner->image_link_1       = 'photos/banner/'.$filename;
             }

            $banner->title 				= Input::get('title');
            $banner->slug 				= Input::get('slug');
            $banner->link 				= Input::get('link');
            $banner->status 			= Input::get('status')?Input::get('status'):0;
            $banner->author_id			= Auth::user()->id;
            
            $banner->save();

            return Redirect::to('admin/banner/index')
                ->with('success_msg', 'Banner Updated successfully');
        }

        return Redirect::to('admin/banner/edit/'.$id)
            ->with('error_msg', 'Banner has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
        
        $banner  = Banner::find($id);
        return View::make('admin.banner.edit')->with(compact('guide'));
    }

    public function getActivate($id,$status='no')
    {
        $banner = Banner::find($id);
        $banner->status   =($status==='yes')?1:0;
        $banner->save();

        return Redirect::back()
            ->with('success_msg', 'Banner Updated successfully');
    }

    public function getDelete($id)
    {
		if(Banner::destroy($id))
		{
			return Redirect::to('admin/banner/index')
                ->with('success_msg', 'Banner Deleted successfully');
		}
		else
		{
			return Redirect::to('admin/banner/index')
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


}
