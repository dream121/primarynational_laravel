<?php

class AgentsController extends FrontendController {

    public function __construct(){
        parent::__construct();
        $this->setTitle('Nick Ratlife Realty Team\'s Real Estate Agents');
        $this->selectMenu('agents');
        $this->setMenu('main_menu_ext_with_sub');

    }

    public function getIndex()
    {
        $agents = Agent::with('profile')->paginate(30);
        return View::make('agents.index')->with(compact('agents'));

    }

    public function getShow($id)
    {
        $agent = Agent::where('id','=',$id)->get()->first();
        return View::make('agents.show')->with(compact('agent'));
    }

}
