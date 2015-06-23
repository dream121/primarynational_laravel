<?php

class UserController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Users');
    }
    
    public function getIndex($recent=0)
    {
        $role_id=Auth::user()->role_id;
        if($role_id==1 || $role_id==2 ){
            if($recent)
                $agents = User::where('recent_status','=',1)->with('profile')->paginate(20);
            else
                $agents = User::with('profile')->paginate(20);
        }else{
            $clients_id=AgentClient::where('agent_id','=',Auth::user()->id)->lists('client_id');
            if(count($clients_id)){
                if($recent)
                    $agents = User::where('recent_status','=',1)->whereIn('id',$clients_id)->with('profile')->paginate(20);
                else
                    $agents = User::whereIn('id',$clients_id)->with('profile')->paginate(20);
            }
            else
                $agents=null;
        }

        return View::make('admin.user.index')->with(compact('agents'));
    }

    public function getCreate()
    {
        return View::make('admin.user.create');
    }

    public function postCreate()
    {
        ini_set('memory_limit','256M');
        $rules=array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email|unique:users,email'
        );
        $validator = Validator::make(Input::all(), $rules);

        $destinationPath = public_path().'/photos/users/';
        
        if ($validator->passes()) {

            if (!file_exists($destinationPath)) {
                mkdir($destinationPath, 0777, true);
            }

            $agent = new User;
            $profile = new Profile;
            
            $img_file = Input::file('photo');

            if($img_file){
                $filename = strtolower(preg_replace('/[^A-Za-z0-9 _ .-]/', '_', time().'-'.$img_file->getClientOriginalName()));
                
                Image::make($img_file)->resize(408,null,function ($constraint) {
                   // prevent possible upsizing
                    $constraint->aspectRatio();
                    $constraint->upsize();

                })->save($destinationPath.$filename); 
                
                $profile->photo       = 'photos/users/'.$filename;
            }
            
            $agent->first_name 			= Input::get('first_name');
            $agent->last_name 			= Input::get('last_name');
            $agent->email               = Input::get('email');
            $agent->phone_number        = Input::get('phone_number');
            $agent->active              = 1;
            $agent->recent_status       = 1;
            $agent->save();
            
            $profile->designation       = Input::get('designation');
            $profile->tagline           = Input::get('tagline');
            $profile->biography         = Input::get('biography');
            $profile->office_name       = Input::get('office_name');
            $profile->office_address_line1     = Input::get('office_address_line1');
            $profile->office_address_line2     = Input::get('office_address_line2');
            
            $agent->profile()->save($profile);

            return Redirect::to('admin/user/index')
            ->with('success_msg', 'User added successfully');
        }

        return Redirect::to('admin/user/create')
        ->with('error_msg', 'There are something wrong!! Please check your inputs again')
        ->withErrors($validator)
        ->withInput();
    }

    public function getShow($id)
    {
        $agent  = User::with('profile')->with('role')->find($id);
        $agent->recent_status=1;
        $agent->save();
        return View::make('admin.user.show')->with(compact('agent'));
    }


    public function getEdit($id)
    {

        $agent  = User::find($id);
        return View::make('admin.user.edit')->with(compact('agent'));
    }

    public function postEdit($id)
    {
        ini_set('memory_limit','256M');

        $agent = User::with('profile')->find($id);
        $rules=array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email|unique:users,email,'.$id
        );
        $validator = Validator::make(Input::all(), $rules);

        $destinationPath = public_path().'/photos/users/';

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
                $photo = 'photos/users/'.$filename;
            }
            
            $agent->first_name              = Input::get('first_name');
            $agent->last_name               = Input::get('last_name');
            $agent->email                   = Input::get('email');
            $agent->phone_number            = Input::get('phone_number');

            if(!empty($agent->profile)){
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

            return Redirect::to('admin/user/index')
            ->with('success_msg', 'User Updated successfully');
        }

        return Redirect::to('admin/user/edit/'.$id)
        ->with('error_msg', 'Something went wrong. Please try again!!!')
        ->withErrors($validator)
        ->withInput();
        
        $agent  = User::find($id);
        return View::make('admin.user.edit')->with(compact('agent'));
    }

    public function getActivate($id,$status='no')
    {
        $agent = User::find($id);
        $agent->active   =($status==='yes')?1:0;
        $agent->save();

        return Redirect::back()
        ->with('success_msg', 'User Updated successfully');
    }

    public function getDelete($id)
    {
        if(User::destroy($id))
        {
            Profile::where('user_id', '=', $id)->delete();
            return Redirect::to('admin/user/index')
            ->with('success_msg', 'User Deleted successfully');
        }
        else
        {
            return Redirect::to('admin/user/index')
            ->with('error_msg', 'Delete Operation Failed');
        }
    }


    public function getResetStatus($id,$status){
        $comment=User::find($id);
        $comment->recent_status=$status;
        $comment->save();
        return Redirect::back()->with('message','Operation Successful !');
    }


}