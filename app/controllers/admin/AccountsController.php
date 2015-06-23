<?php

class AccountsController extends AdminController {

//	protected $viewBase = "account";

    public function __construct(){
        parent::__construct();
        View::share('page_title', 'Manage Account');
    }

    public function getIndex()
    {
//        echo "test";
        $user=User::with('profile')->find(Auth::user()->id);
//        dd($user->toArray());
        $this->view('admin.account.show')->with(compact('user'));

    }

    public function postAccount(){

        ini_set('memory_limit','256M');

        $user = User::with('profile')->find(Auth::user()->id);
        $rules=array(
            'first_name'=>'required',
            'last_name'=>'required'
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

            $user->first_name              = Input::get('first_name');
            $user->last_name               = Input::get('last_name');
//            $user->email                   = Input::get('email');
            $user->phone_number            = Input::get('phone_number');

            if(!empty($user->profile)){
                $user->profile->designation    = Input::get('designation');
                $user->profile->tagline        = Input::get('tagline');
                $user->profile->biography      = Input::get('biography');
                $user->profile->office_name    = Input::get('office_name');
                $user->profile->office_address_line1      = Input::get('office_address_line1');
                $user->profile->office_address_line2      = Input::get('office_address_line2');
                if($photo)
                    $user->profile->photo          = $photo;
                $user->push();
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
                $user->profile()->save($profile);
            }

            return Redirect::to('admin/profile')
                ->with('success_msg', 'Agent Updated successfully');
        }

        return Redirect::to('admin/profile')
            ->with('error_msg', 'Something went wrong. Please try again!!!')
            ->withErrors($validator)
            ->withInput();
    }

    public function postChangePassword(){
        
        $input = Input::all();
        
        $user = Auth::user();
        $rules = array(
            'current_password' => 'required|between:6,16',
            'new_password' => 'required|between:6,16|confirmed',
            'new_password_confirmation' => 'required|between:6,16|same:new_password'
        );

        $validator = Validator::make($input, $rules);

        if ($validator->fails()) 
        {
            $errors = $validator->messages()->toArray();
            $msg_str = '<ul>';
            foreach($errors as $key => $msg)
            {
                $msg_str .= '<li>'.$msg[0].'</li>';
            }
            $msg_str .= '</ul>';
            return Redirect::back()
                ->with('error_msg', 'Validation Failed.')
                ->withErrors($validator)
                ->withInput();
        } 
        else 
        {
            if (!Hash::check(Input::get('current_password'), $user->password)) 
            {
                return Redirect::back()
                    ->with('error_msg', 'Current password  does not match.')
                    ->withErrors($validator)
                    ->withInput();
            }
            else
            {
                $user->password = Hash::make(Input::get('new_password'));
                $user->save();
                return Redirect::back()
                    ->with('success_msg', 'Password updated successfully');
            }
        }

    }

}
