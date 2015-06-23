<?php

class PageController extends FrontendController {

    public function __construct(){
        parent::__construct();
    }

    public function getShow($slug = null){

        $page = Page::where('slug','=',$slug)->get()->first();

        return View::make('page.show')->with(compact('page'));

    }



}
