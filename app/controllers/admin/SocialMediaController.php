<?php

class SocialMediaController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Social Media');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $social_media = SocialMedia::paginate(30);
        return View::make('admin.social_media.index')->with(compact('social_media'));
    }


    public function getCreate()
    {
        return View::make('admin.social_media.create');
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), SocialMedia::rules());

        $destinationPath = public_path().'/photos/';

        if ($validator->passes()) {

            $social_media = new SocialMedia;
            //$full_path=public_path().DS.'photos'.DS;
            $files = Input::file('image_file');
            $i=1;
            foreach($files as $key=>$file)
            {
                if($file)
                {
                    $filename 		= preg_replace('/[^A-Za-z0-9 _ .-]/', '_', $file->getClientOriginalName());
                    $uploadSuccess 	= $file->move($destinationPath, $filename);

                    if($uploadSuccess){
                        $img_n = 'image_link_'.$i;
                        $social_media->$img_n		= url('photos/'.$filename);
                    }
                    $i++;
                    if($i>4)
                        break;
                }

            }

            $social_media->title 				= Input::get('title');
            $social_media->slug 				= Input::get('slug');
            $social_media->link 				= Input::get('link');
            $social_media->status 				= Input::has('status')?Input::get('status'):0;
            $social_media->author_id			= Auth::user()->id;
            //$social_media->war_type_description 	= Input::get('war_type_description');


            $social_media->save();
            $social_icons = SocialMedia::where('status','=',1)->get();
            Cache::put('social_icons', $social_icons, 30);
            return Redirect::to('admin/social_media/index')
                ->with('success_msg', 'Social Media created successfully');
        }

        return Redirect::to('admin/social_media/create')
            ->with('error_msg', 'Social Media has not Saved Successfully.')
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
        $social_media  = SocialMedia::find($id);
        //$author = $social_media->author();
        return View::make('admin.social_media.show')->with(compact('social_media'));
    }


    public function getEdit($id)
    {

        $social_media  = SocialMedia::find($id);
        return View::make('admin.social_media.edit')->with(compact('social_media'));
    }
	
	public function postEdit($id)
    {
		$social_media = SocialMedia::find($id);
        $validator = Validator::make(Input::all(), SocialMedia::rules($id));

        $destinationPath = public_path().'/photos/';

        if ($validator->passes()) {
            $files = Input::file('image_file');
            $i=1;
            foreach($files as $key=>$file)
            {
                if($file)
                {
                    $filename 		= preg_replace('/[^A-Za-z0-9_\-]./', '_', $file->getClientOriginalName());
                    $uploadSuccess 	= $file->move($destinationPath, $filename);

                    if($uploadSuccess){
                        $img_n = 'image_link_'.$i;
                        $social_media->$img_n			= url('photos/'.$filename);
                    }
                    $i++;
                    if($i>4)
                        break;
                }
            }

			
            $social_media->title 				= Input::get('title');
            $social_media->slug 				= Input::get('slug');
            $social_media->link 				= Input::get('link');
            $social_media->status 				= Input::has('status')?Input::get('status'):0;
            $social_media->author_id			= Auth::user()->id;
            //$social_media->war_type_description 	= Input::get('war_type_description');


            $social_media->save();
            $social_icons = SocialMedia::where('status','=',1)->get();
            Cache::put('social_icons', $social_icons, 30);
            return Redirect::to('admin/social_media/index')
                ->with('success_msg', 'Social Media Updated successfully');
        }

        return Redirect::to('admin/social_media/edit/'.$id)
            ->with('error_msg', 'Social Media has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
        
        $social_media  = SocialMedia::find($id);
        return View::make('admin.social_media.edit')->with(compact('guide'));
    }

    public function getActivate($id,$status='no')
    {
        $social_media = SocialMedia::find($id);
        $social_media->status   =($status==='yes')?1:0;
        $social_media->save();

        return Redirect::back()
            ->with('success_msg', 'Social Media Updated successfully');
    }

    public function getDelete($id)
    {
		if(SocialMedia::destroy($id))
		{
			return Redirect::to('admin/social_media/index')
                ->with('success_msg', 'Social Media Deleted successfully');
		}
		else
		{
			return Redirect::to('admin/social_media/index')
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
