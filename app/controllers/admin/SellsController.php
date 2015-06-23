<?php

class SellsController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Sell Page');
    }

    public function getEdit($id=null)
    {

        $sell  = Sell::get()->first();
        if(!$sell){
            $sell = new stdClass;
            $sell->id = null;
            $sell->title = '';
            $sell->content = '';
        }
        return View::make('admin.sell.edit')->with(compact('sell'));
    }
	
	public function postEdit()
    {

        $validator = Validator::make(Input::all(), Sell::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $sell = Sell::find($id);
            else
                $sell = new Sell();
            $sell->title 				= Input::get('title');
            $sell->content 			    = Input::get('content');
            $sell->status 				= 1;
            $sell->author_id			= Auth::user()->id;

            $sell->save();

            return Redirect::to('admin/sell')
                ->with('success_msg', 'Sell Page Updated successfully');
        }

        return Redirect::to('admin/sell/')
            ->with('error_msg', 'Sell Page has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }

    public function getActivate($id,$status='no')
    {
        $sell = WelcomeNote::find($id);
        $sell->status   =$status==='yes'?1:0;
        $sell->save();

        return Redirect::back()
            ->with('success_msg', 'Sell Page Updated successfully');
    }


}
