<?php

class FinancialAgentController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Mortgage Lenders');
    }
    
    public function getIndex()
    {
        $agents = FinancialAgent::with('profile')->paginate(30);
        return View::make('admin.financial_agent.index')->with(compact('agents'));
    }

    public function getCreate()
    {
        return View::make('admin.financial_agent.create');
    }

    public function postCreate()
    {
        ini_set('memory_limit','256M');
        
        $validator = Validator::make(Input::all(), FinancialAgent::rules());

        $destinationPath = public_path().'/photos/financial_agents/';
        
        if ($validator->passes()) {

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $agent = new FinancialAgent;
            $profile = new Profile;
            
            $img_file = Input::file('photo');

            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(204, 216,function ($constraint) {
                   
                })->save($destinationPath.$filename); 
                
                $profile->photo       = 'photos/financial_agents/'.$filename;
            }
            
            $agent->first_name 			= Input::get('first_name');
            $agent->last_name 			= Input::get('last_name');
            $agent->email               = Input::get('email');
            $agent->phone_number        = Input::get('phone_number');
            $agent->active              = 1;
            $agent->recent_status       = 1;
            $agent->save();

            $profile->agent_id          = Input::get('agent_id');
            $profile->designation       = Input::get('designation');
            $profile->tagline           = Input::get('tagline');
            $profile->biography         = Input::get('biography');
            $profile->office_name       = Input::get('office_name');
            $profile->office_address_line1     = Input::get('office_address_line1');
            $profile->office_address_line2     = Input::get('office_address_line2');
            
            $agent->profile()->save($profile);

            return Redirect::to('admin/financial-agent/index')
            ->with('success_msg', 'Agent added successfully');
        }

        return Redirect::to('admin/financial-agent/create')
        ->with('error_msg', 'There are someting wrong!! Please check your inputs again')
        ->withErrors($validator)
        ->withInput();
    }

    public function getShow($id)
    {
        $agent  = FinancialAgent::with('profile')->with('role')->find($id);
        return View::make('admin.financial_agent.show')->with(compact('agent'));
    }


    public function getEdit($id)
    {

        $agent  = FinancialAgent::with('profile')->find($id);
        return View::make('admin.financial_agent.edit')->with(compact('agent'));
    }

    public function postEdit($id)
    {
        ini_set('memory_limit','256M');

        $financial_agent = FinancialAgent::with('profile')->find($id);
        
        $validator = Validator::make(Input::all(), FinancialAgent::rules($id));

        $destinationPath = public_path().'/photos/financial_agents/';

        if ($validator->passes()) {

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $img_file = Input::file('photo');
            $photo = '';
            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                Image::make($img_file)->resize(204, 216,function ($constraint) {
                   
                })->save($destinationPath.$filename); 
                $photo = 'photos/financial_agents/'.$filename;
            }
            
            $financial_agent->first_name              = Input::get('first_name');
            $financial_agent->last_name               = Input::get('last_name');
            $financial_agent->email                   = Input::get('email');
            $financial_agent->phone_number            = Input::get('phone_number');

            if(Input::get('profile_id')){

                $financial_agent->profile->agent_id       = Input::get('agent_id');
                $financial_agent->profile->designation    = Input::get('designation');
                $financial_agent->profile->tagline        = Input::get('tagline');
                $financial_agent->profile->biography      = Input::get('biography');
                $financial_agent->profile->office_name    = Input::get('office_name');
                $financial_agent->profile->office_address_line1      = Input::get('office_address_line1');
                $financial_agent->profile->office_address_line2      = Input::get('office_address_line2');
                if($photo)
                $financial_agent->profile->photo          = $photo;
                $financial_agent->push();
            }else{
                $profile = new Profile;
                $profile->agent_id          = Input::get('agent_id');
                $profile->designation       = Input::get('designation');
                $profile->tagline           = Input::get('tagline');
                $profile->biography         = Input::get('biography');
                $profile->office_name       = Input::get('office_name');
                $profile->office_address_line1     = Input::get('office_address_line1');
                $profile->office_address_line2     = Input::get('office_address_line2');
                if($photo)
                $profile->photo             = $photo;
                $financial_agent->profile()->save($profile);
            }

            return Redirect::to('admin/financial-agent/index')
            ->with('success_msg', 'Agent Updated successfully');
        }

        return Redirect::to('admin/financial-agent/edit/'.$id)
        ->with('error_msg', 'Something went wrong. Please try again!!!')
        ->withErrors($validator)
        ->withInput();
    }

    public function getActivate($id,$status='no')
    {
        $agent = FinancialAgent::find($id);
        $agent->active   =($status==='yes')?1:0;
        $agent->save();

        return Redirect::back()
        ->with('success_msg', 'Agent Updated successfully');
    }

    public function getDelete($id)
    {
      if(FinancialAgent::destroy($id))
      {
        Profile::where('user_id', '=', $id)->delete();
        return Redirect::to('admin/financial-agent/index')
        ->with('success_msg', 'Agent Deleted successfully');
    }
    else
    {
     return Redirect::to('admin/financial-agent/index')
     ->with('error_msg', 'Delete Operation Failed');
 }
}

}