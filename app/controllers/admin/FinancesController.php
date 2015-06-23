<?php

class FinancesController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Finance Page');
    }

    public function getEdit($id=null)
    {

        $finance  = Finance::get()->first();
        if(!$finance){
            $finance = new stdClass;
            $finance->id = null;
            $finance->title = '';
            $finance->content = '';
        }
        return View::make('admin.finance.edit')->with(compact('finance'));
    }
	
	public function postEdit()
    {

        $validator = Validator::make(Input::all(), Finance::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $finance = Finance::find($id);
            else
                $finance = new Finance();
            $finance->title 				= Input::get('title');
            $finance->content 			    = Input::get('content');
            $finance->status 				= 1;
            $finance->author_id			= Auth::user()->id;

            $finance->save();

            return Redirect::to('admin/finance')
                ->with('success_msg', 'Finance Page Updated successfully');
        }

        return Redirect::to('admin/finance/')
            ->with('error_msg', 'Finance Page has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }

    public function getActivate($id,$status='no')
    {
        $finance = WelcomeNote::find($id);
        $finance->status   =$status==='yes'?1:0;
        $finance->save();

        return Redirect::back()
            ->with('success_msg', 'Finance Page Updated successfully');
    }


}
