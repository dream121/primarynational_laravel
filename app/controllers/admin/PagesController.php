<?php

class PagesController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Content Management');
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return Response
	 */
	public function getIndex()
	{
        $pages = Page::paginate(30);
        return View::make('admin.pages.index')->with('pages',$pages);
	}


	public function getCreate()
	{
        return View::make('admin.pages.create');
	}

    public function postCreate()
	{
        $validator = Validator::make(Input::all(), Page::rules());

        if ($validator->passes()) {

            $page = new Page;
            $page->title 				= Input::get('title');
            $page->details 				= Input::get('details');
            $page->slug 				= Input::get('slug');
            //$page->war_type_description 	= Input::get('war_type_description');


            $page->save();
            $about_us = Page::where('slug','=','about-us')->get()->first();
            Cache::put('about_us', $about_us, 30);
            return Redirect::to('admin/page/index')
                ->with('success_msg', 'Page created successfully');
        }

        return Redirect::to('admin/page/create')
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
        $page  = Page::find($id);
        return View::make('admin.pages.show')->with(compact('page'));
    }



    public function getEdit($id)
    {

        $page  = Page::find($id);
        return View::make('admin.pages.edit')->with(compact('page'));
    }

    public function postEdit($id)
    {
        $page = Page::find($id);
        $validator = Validator::make(Input::all(), Page::rules($id));

        if ($validator->passes()) {

            $page->title 				= Input::get('title');
            $page->details 				= Input::get('details');
            $page->slug 				= Input::get('slug');
            $page->save();
            $about_us = Page::where('slug','=','about-us')->get()->first();
            Cache::put('about_us', $about_us, 30);
            return Redirect::to('admin/page/index')
                ->with('success_msg', 'Page Updated successfully');
        }

        return Redirect::to('admin/page/edit/'.$id)
            ->with('error_msg', 'Page has not Saved Successfully.')
            ->withErrors($validator)
            ->withInput();

        $page  = Page::find($id);
        return View::make('admin.pages.edit')->with(compact('page'));
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
