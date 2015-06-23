<?php

class PressController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Press');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $presses = Press::paginate(30);
        /*dd($press);*/
        /*echo "<pre>";
        print_r($press);
        echo "</pre>";die;*/
        return View::make('admin.press.index')->with(compact('presses'));
    }


    public function getCreate()
    {
        return View::make('admin.press.create');
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), Press::rules());

        $destinationPath = public_path().'/photos/';

        if ($validator->passes()) {

            $press = new Press;
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
                        $press->$img_n			= url('photos/'.$filename);
                    }
                    $i++;
                    if($i>4)
                        break;
                }

            }

            $press->title 				= Input::get('title');
            $press->content 			= Input::get('content');
            $press->slug 				= Input::get('slug');
            $press->status 				= Input::has('status')?Input::get('status'):0;
            $press->author_id			= Auth::user()->id;
            //$press->war_type_description 	= Input::get('war_type_description');


            $press->save();

            return Redirect::to('admin/press/index')
                ->with('success_msg', 'Press created successfully');
        }

        return Redirect::to('admin/press/create')
            ->with('error_msg', 'Press has not Saved Successfully.')
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
        $press  = Press::find($id);
        return View::make('admin.press.show')->with(compact('press'));
    }



    public function getEdit($id)
    {

        $press  = Press::find($id);
        return View::make('admin.press.edit')->with(compact('press'));
    }
	
	public function postEdit($id)
    {
		$press = Press::find($id);
        $validator = Validator::make(Input::all(), Press::rules($id));

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
                        $press->$img_n			= url('photos/'.$filename);
                    }
                    $i++;
                    if($i>4)
                        break;
                }
            }



            $press->title 				= Input::get('title');
            $press->content 			= Input::get('content');
            $press->slug 				= Input::get('slug');
            $press->status 				= Input::get('status');
            $press->author_id			= Auth::user()->id;
            //$press->war_type_description 	= Input::get('war_type_description');


            $press->save();

            return Redirect::to('admin/press/index')
                ->with('success_msg', 'Press Updated successfully');
        }

        return Redirect::to('admin/press/edit/'.$id)
            ->with('error_msg', 'Press has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
        
        $press  = Press::find($id);
        return View::make('admin.press.edit')->with(compact('press'));
    }

    public function getActivate($id,$status='no')
    {
        $press = Press::find($id);
        $press->status   =($status==='yes')?1:0;
        $press->save();

        return Redirect::back()
            ->with('success_msg', 'Press Updated successfully');
    }

    public function getDelete($id)
    {
		if(Press::destroy($id))
		{
			return Redirect::to('admin/press/index')
                ->with('success_msg', 'Press Deleted successfully');
		}
		else
		{
			return Redirect::to('admin/press/index')
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
