<?php

class ManageController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Panage Pages');
    }

    public function getEditAboutUs($slug = 'about-us')
    {
        View::share('page_title', 'Update About Us');
        $about_us = Page::where('slug','=','about-us')->get()->first();
        return View::make('admin.manage.edit_about_us')->with(compact('about_us'));
    }
    
    public function postEditAboutUs()
    {

        $validator = Validator::make(Input::all(), Page::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $page = Page::find($id);
            else
                $page = new Page();
            $page->title                = Input::get('title');
            $page->details              = Input::get('details');
            $page->slug                 = 'about-us';
            
            $page->save();

            return Redirect::to('admin/manage/edit-about-us')
                ->with('success_msg', 'About us Updated successfully');
        }

        return Redirect::to('admin/manage/edit-about-us')
            ->with('error_msg', 'About us has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }

    public function getEditContactUs()
    {
        View::share('page_title', 'Update Contact Us');
        $contact_us = ContactUs::get()->first();
        if(!$contact_us){
            $contact_us = new stdClass;
            $contact_us->id = null;
            $contact_us->title = '';
            $contact_us->content = '';
        }
        
        return View::make('admin.manage.edit_contact_us')->with(compact('contact_us'));
    }
	
	public function postEditContactUs()
    {

        $validator = Validator::make(Input::all(), ContactUs::rules());
        if ($validator->passes()) {
            $id = Input::get('id');
            if($id)
                $ContactUs = ContactUs::find($id);
            else
                $ContactUs = new ContactUs();
            $ContactUs->title                = Input::get('title');
            $ContactUs->content              = Input::get('content');
            $ContactUs->status              = 1;
            $ContactUs->author_id           = Auth::user()->id;
            
            $ContactUs->save();

            return Redirect::to('admin/manage/edit-contact-us')
                ->with('success_msg', 'Contact data Updated successfully');
        }

        return Redirect::to('admin/manage/edit-contact-us')
            ->with('error_msg', 'Contact data has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

    }



}
