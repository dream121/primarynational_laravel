<?php

class GuidesController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Guide');
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function getIndex()
    {
        $guides = Guide::paginate(30);
        return View::make('admin.guides.index')->with(compact('guides'));
    }


    public function getCreate()
    {
        $states=array('Massachusetts'=>'Massachusetts','Rhode Island'=>'Rhode Island');
        $cities=array('Massachusetts'=>
            array('Boston'=>'Boston','Sharon'=>'Sharon','Brookline'=>'Brookline','Watertown'=>'Watertown','East Providence'=>'East Providence','Lexington'=>'Lexington','Newport'=>'Newport','Pawtucket'=>'Pawtucket'),
            'Rhode Island'=>
                array('Braintree'=>'Braintree','Cranston'=>'Cranston','Franklin'=>'Franklin','Lincoln'=>'Lincoln','Newton'=>'Newton','Providence'=>'Providence','Warwick'=>'Warwick','Woonsocket'=>'Woonsocket')
        );
        return View::make('admin.guides.create')->with(compact('states','cities'));
    }

    public function postCreate()
    {
        $validator = Validator::make(Input::all(), Guide::rules());

        $destinationPath = public_path().'/photos/guides/';

        if ($validator->passes()) {

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }

            $guide = new Guide;
            
            $img_file = Input::file('image_file');
            
            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(1200,null,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $guide->image_link_1       = 'photos/guides/'.$filename;
            }


            $guide->title 				= Input::get('title');
            $guide->content 			= Input::get('content');
            $guide->slug 				= Input::get('slug');
            $guide->state 				= Input::get('state');
            $guide->city 				= Input::get('city');
            $guide->link 				= Input::get('link');
            $guide->status 				= Input::has('status')?Input::get('status'):0;
            $guide->author_id			= Auth::user()->id;
            
            $guide->save();
            $guide_lists = Guide::where('status','=',1)->select('title','slug')->get();
            Cache::put('guide_lists', $guide_lists, 30);
            return Redirect::to('admin/guide/index')
                ->with('success_msg', 'Guide created successfully');
        }

        return Redirect::to('admin/guide/create')
            ->with('error_msg', 'Guide has not Saved Successfully.')
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
        $guide  = Guide::find($id);
        return View::make('admin.guides.show')->with(compact('guide'));
    }



    public function getEdit($id)
    {
        $states=array('Massachusetts'=>'Massachusetts','Rhode Island'=>'Rhode Island');
        $cities=array('Massachusetts'=>
            array('Boston'=>'Boston','Sharon'=>'Sharon','Brookline'=>'Brookline','Watertown'=>'Watertown','East Providence'=>'East Providence','Lexington'=>'Lexington','Newport'=>'Newport','Pawtucket'=>'Pawtucket'),
            'Rhode Island'=>
                array('Braintree'=>'Braintree','Cranston'=>'Cranston','Franklin'=>'Franklin','Lincoln'=>'Lincoln','Newton'=>'Newton','Providence'=>'Providence','Warwick'=>'Warwick','Woonsocket'=>'Woonsocket')
        );
        $guide  = Guide::find($id);
        return View::make('admin.guides.edit')->with(compact('guide','states','cities'));
    }
	
	public function postEdit($id)
    {
		$guide = Guide::find($id);
        $validator = Validator::make(Input::all(), Guide::rules($id));

        $destinationPath = public_path().'/photos/guides/';

        if ($validator->passes()) {

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }

            $img_file = Input::file('image_file');

            if($img_file){
                
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(1200,null,function ($constraint) {
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $guide->image_link_1       = 'photos/guides/'.$filename;
            }

			
            $guide->title 				= Input::get('title');
            $guide->content 			= Input::get('content');
            $guide->slug 				= Input::get('slug');
            $guide->state 				= Input::get('state');
            $guide->city 				= Input::get('city');
            $guide->link 				= Input::get('link');
            $guide->status 				= Input::get('status');
            $guide->author_id			= Auth::user()->id;
            //$guide->war_type_description 	= Input::get('war_type_description');


            $guide->save();
            $guide_lists = Guide::where('status','=',1)->select('title','slug')->get();
            Cache::put('guide_lists', $guide_lists, 30);
            return Redirect::to('admin/guide/index')
                ->with('success_msg', 'Guide Updated successfully');
        }

        return Redirect::to('admin/guide/edit/'.$id)
            ->with('error_msg', 'Guide has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();
        
        $guide  = Guide::find($id);
        return View::make('admin.guides.edit')->with(compact('guide'));
    }

    public function getActivate($id,$status='no')
    {
        $guide = Guide::find($id);
        $guide->status   =($status==='yes')?1:0;
        $guide->save();

        return Redirect::back()
            ->with('success_msg', 'Guide Updated successfully');
    }

    public function getDelete($id)
    {
		if(Guide::destroy($id))
		{
			return Redirect::to('admin/guide/index')
                ->with('success_msg', 'Guide Deleted successfully');
		}
		else
		{
			return Redirect::to('admin/guide/index')
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
