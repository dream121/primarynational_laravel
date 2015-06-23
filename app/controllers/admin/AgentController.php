<?php

class AgentController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Agents');
    }
    
    public function getIndex()
    {
        $agents = Agent::with('profile')->paginate(30);
        return View::make('admin.agent.index')->with(compact('agents'));
    }

    public function getCreate()
    {
        return View::make('admin.agent.create');
    }

    public function postCreate()
    {
        ini_set('memory_limit','256M');
        
        $validator = Validator::make(Input::all(), Agent::rules());

        $destinationPath = public_path().'/photos/agents/';
        
        if ($validator->passes()) {

            if(!File::exists($destinationPath))
            {
                File::makeDirectory($destinationPath, 0777, true);
            }

            $agent = new Agent;
            
            $profile = new Profile;
            
            $img_file = Input::file('photo');

            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(408,null,function ($constraint) {
                   // prevent possible upsizing
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $profile->photo       = 'photos/agents/'.$filename;
            }
            
            $agent->first_name 			= Input::get('first_name');
            $agent->last_name 			= Input::get('last_name');
            $agent->email               = Input::get('email');
            $agent->phone_number               = Input::get('phone_number');
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

            return Redirect::to('admin/agent/index')
            ->with('success_msg', 'Agent added successfully');
        }

        return Redirect::to('admin/agent/create')
        ->with('error_msg', 'There are something wrong!! Please check your inputs again')
        ->withErrors($validator)
        ->withInput();
    }

    public function getShow($id)
    {
        $agent  = Agent::with('profile')->with('role')->find($id);
        return View::make('admin.agent.show')->with(compact('agent'));
    }


    public function getEdit($id)
    {

        $agent  = Agent::with('profile')->find($id);
        return View::make('admin.agent.edit')->with(compact('agent'));
    }

    public function postEdit($id)
    {
        ini_set('memory_limit','256M');

        $agent = Agent::find($id);
        
        $validator = Validator::make(Input::all(), Agent::rules($id));

        $destinationPath = public_path().'/photos/agents/';

        if ($validator->passes()) {

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $img_file = Input::file('photo');
            $photo = '';
            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                 Image::make($img_file)->resize(408,null,function ($constraint) {
                   // prevent possible upsizing
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                $photo = 'photos/agents/'.$filename;
            }
            
            $agent->first_name              = Input::get('first_name');
            $agent->last_name               = Input::get('last_name');
            $agent->email                   = Input::get('email');
            $agent->phone_number            = Input::get('phone_number');

            if(Input::get('profile_id')){
                $agent->profile->agent_id       = Input::get('agent_id');
                $agent->profile->designation    = Input::get('designation');
                $agent->profile->tagline        = Input::get('tagline');
                $agent->profile->biography      = Input::get('biography');
                $agent->profile->office_name    = Input::get('office_name');
                $agent->profile->office_address_line1      = Input::get('office_address_line1');
                $agent->profile->office_address_line2      = Input::get('office_address_line2');
                if($photo)
                $agent->profile->photo          = $photo;
                $agent->push();
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
                $agent->profile()->save($profile);    
            }

            return Redirect::to('admin/agent/index')
            ->with('success_msg', 'Agent Updated successfully');
        }

        return Redirect::to('admin/agent/edit/'.$id)
        ->with('error_msg', 'Something went wrong. Please try again!!!')
        ->withErrors($validator)
        ->withInput();

    }

    public function getActivate($id,$status='no')
    {
        $agent = Agent::find($id);
        $agent->active   =($status==='yes')?1:0;
        $agent->save();

        return Redirect::back()
        ->with('success_msg', 'Agent Updated successfully');
    }

    public function getDelete($id)
    {
      if(Agent::destroy($id))
      {
        Profile::where('user_id', '=', $id)->delete();
        return Redirect::to('admin/agent/index')
        ->with('success_msg', 'Agent Deleted successfully');
    }
    else
    {
     return Redirect::to('admin/agent/index')
     ->with('error_msg', 'Delete Operation Failed');
 }
}

}