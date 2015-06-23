<?php

class WelcomeNoteController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Welcome Note');
    }

    public function getEdit($id=null)
    {

        $welcome_note  = WelcomeNote::get()->first();
        if(!$welcome_note){
            $welcome_note = new stdClass;
            $welcome_note->id = null;
            $welcome_note->title = '';
            $welcome_note->content = '';
        }
        return View::make('admin.welcome_note.edit')->with(compact('welcome_note'));
    }
	
	public function postEdit()
    {

        $validator = Validator::make(Input::all(), WelcomeNote::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $welcome_note = WelcomeNote::find($id);
            else
                $welcome_note = new WelcomeNote();
            $welcome_note->title 				= Input::get('title');
            $welcome_note->content 			    = Input::get('content');
            $welcome_note->status 				= 1;
            $welcome_note->author_id			= Auth::user()->id;

            $welcome_note->save();

            return Redirect::to('admin/welcome_note')
                ->with('success_msg', 'Welcome Note Updated successfully');
        }

        return Redirect::to('admin/welcome_note/')
            ->with('error_msg', 'Welcome Note has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }

    public function getActivate($id,$status='no')
    {
        $welcome_note = WelcomeNote::find($id);
        $welcome_note->status   =$status==='yes'?1:0;
        $welcome_note->save();

        return Redirect::back()
            ->with('success_msg', 'Welcome Note Updated successfully');
    }


}
