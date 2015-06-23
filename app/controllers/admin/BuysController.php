<?php

class BuysController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Buy Page');
    }

    public function getEdit($id=null)
    {

        $buy  = Buy::get()->first();
        if(!$buy){
            $buy = new stdClass;
            $buy->id = null;
            $buy->title = '';
            $buy->content = '';
        }
        return View::make('admin.buy.edit')->with(compact('buy'));
    }
	
	public function postEdit()
    {

        $validator = Validator::make(Input::all(), Buy::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $buy = Buy::find($id);
            else
                $buy = new Buy();
            $buy->title 				= Input::get('title');
            $buy->content 			    = Input::get('content');
            $buy->status 				= 1;
            $buy->author_id			= Auth::user()->id;

            $buy->save();

            return Redirect::to('admin/buy')
                ->with('success_msg', 'Buy Page Updated successfully');
        }

        return Redirect::to('admin/buy/')
            ->with('error_msg', 'Buy Page has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }

    public function getActivate($id,$status='no')
    {
        $buy = WelcomeNote::find($id);
        $buy->status   =$status==='yes'?1:0;
        $buy->save();

        return Redirect::back()
            ->with('success_msg', 'Buy Page Updated successfully');
    }


}
