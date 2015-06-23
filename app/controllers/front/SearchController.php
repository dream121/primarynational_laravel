<?php

class SearchController extends FrontendController {

    private $input = array();
    private $uri = array();

    public function __construct(){
        parent::__construct();
        $this->setTitle('Search page');
        $this->selectMenu('search');
        $this->setMenu('main_menu_extended');
        $this->inputs = Input::All();
        $agent=$this->agent;
        View::share(compact('agent'));
        $this->uri = str_replace(' ','+',urldecode(Request::getQueryString()));
//        dd($this->uri);die;
        View::share('uri',$this->uri);
        if(isset($this->inputs['OfficeMLS'])){
            $this->selectMenu('search?OfficeMLS=BB9805');
        }



    }

    public function getIndex()
    {
        $this->setFooter('search_footer');
        $this->setSubmenu('photo');
        $inputs =  $this->inputs;
        return View::make('search.photo')->with(compact('inputs'));
    }


    public function getMap()
    {
        $this->setSubmenu('map');
        $this->selectMenu('search/map');
        $this->inputs['map'] = true;
        $inputs =  $this->inputs;
        return View::make('search.map')->with(compact('inputs'));
    }


    public function getGallery()
    {
        $this->setSubmenu('gallery');
        $inputs =  $this->inputs;
        return View::make('search.gallery')->with(compact('inputs'));
    }

}