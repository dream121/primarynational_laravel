<?php

class AuthController extends FrontendController
{
    private $userid = null;
    
    public function __construct()
    {
        parent::__construct();
        
    }
    
    public function getLogin()
    {
        if (Auth::check()) {
            return Redirect::to('account');
        }
        
        $this->setTitle('Nick Ratlife Realty Team\'s Real Estate Agents');
        $this->selectMenu('sign_in');
        $this->setMenu('main_menu_ext_with_sub');
        return View::make('auth.login');
    }
    
    public function postLogin()
    {
        
        $rules = array(
            'email' => 'required|email',
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
        
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            if (Request::ajax()) {
                return Response::json(array(
                    'error' => true,
                    'redirect' => URL::previous(),
                    'error_msg' => 'Please check your email/password!!!'
                ));
            } else {
                return Redirect::to('login')->with('error_msg', 'Please check your email/password!!!')->withErrors($validator) // send back all errors to the login form
                    ->withInput(Input::except('password')); // send back the input (not the password) so that we can repopulate the form
            }
        } else {
            
            // create our user data for the authentication
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Input::get('password'),
                'active' => 1,
            );
            
            // attempt to do the login
            if (Auth::attempt($userdata)) {
                if(Auth::user()->role_id==4){
                    $this->setClientAgent();
                }
                if (Request::ajax()) {
                    return Response::json(array(
                        'success' => true,
                        'redirect' => URL::previous()
                    ));
                } else {
                    return Redirect::intended('/');
                }
                
            } else {
                
                if (Request::ajax()) {
                    return Response::json(array(
                        'error' => true,
                        'redirect' => URL::previous(),
                        'error_msg' => 'Please check your email/password!!!'
                    ));
                    
                } else {
                    
                    return Redirect::to('login')->with('error_msg', 'Please check your email/password!!!')->withInput(Input::except('password'));
                }
                
            }
            
        }
    }

    public function getLogout()
    {
        Auth::logout();
        return Redirect::to('login')->with('success_msg', 'Your are now logged out!');
    }

    public function getForgotPassword(){

    }


    public function getRegister()
    {
        return View::make('auth.register');
    }
    
    public function postRegister()
    {
        
        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
            'password' => 'required|alphaNum|min:3' // password can only be alphanumeric and has to be greater than 3 characters
        );
        
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);
        
        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Redirect::to('register')->with('message', 'Something wrong!!!')->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::all()); // send back the input (not the password) so that we can repopulate the form
        } else {
            
            // create our user data for the authentication
            $userdata = array(
                'email' => Input::get('email'),
                'password' => Hash::make(Input::get('password'))
            );
            
            // attempt to do the login
            if ($user = User::create($userdata)) {
                
                echo 'SUCCESS!';
                
            } else {
                
                return Redirect::to('register')->with('message', 'Could not save data to the database. Please try again!!!')->withInput(Input::except('password'));
            }
            
        }
        
    }
    public function postFreeMlsRegister()
    {
        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), Member::rules());

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
//            print_r($validator->errors()->toArray());die;
            if(Request::ajax())
            {
                return Response::json(array(
                    'success' => false,
                    'errors' => $validator->errors()->toArray(),
                    'message' => 'Something wrong!!!',

                ), 200);
            }else{
                return Redirect::to('register')->with('message', 'Something wrong!!!')->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::all()); // send back the input (not the password) so that we can repopulate the form
            }

        } else {

            // create our user data for the authentication
            $userdata = array(
                'first_name' => Input::get('first_name'),
                'last_name' => Input::get('last_name'),
                'email' => Input::get('email'),
                'phone_number' => Input::get('phone_number'),
                'local_lender_required' => Input::get('local_lender_required'),
                'password' => Hash::make(Input::get('phone_number')),
                'token' => str_random(60),
                'recent_status' => 1,
            );
            $cred= null;
            // attempt to do the login
            if ($user = Member::create($userdata)) {
//                activation email
                $cred['data'] = $userdata;
                $cred['to'] = Input::get('email');
                $cred['receiver_name'] =  Input::get('first_name')." ". Input::get('last_name');
                $cred['subject'] = "Thanks for Registering at Nick Ratlife Realty Team\'s Real Estate Agents. Activation Require.";
                $cred['view'] = "emails.auth.activation";
                $this->_sendEmail($cred);
// admin email
                $cred['to'] = Config::get('mail.username');
                $cred['subject'] = Input::get('first_name')." ". Input::get('last_name')."has Registered as new Member";
                $cred['view'] = "emails.auth.registration";
                $this->_sendEmail($cred);

                if(Request::ajax())
                    return Response::json(array('success' => true,'message'=> 'User Create Successfully'), 200);
                else
                    return Redirect::to('register/member')->with('message', 'User Create Successfully');

            } else {
                if(Request::ajax())
                    return Response::json(array(
                        'success' => false,
                        'message' => 'Could not Create Member. Try Again...',

                    ), 200);
                else
                    return Redirect::to('register/member')->with('message', 'Could not save data to the database. Please try again!!!')->withInput(Input::except('password'));
            }

        }

    }

    public function activate($email,$token){

        if($user=User::where('email','=',$email)->where('token','=',$token)->get()->first()){
            $user->token='';
            $user->active=1;
            $user->save();
            return Redirect::to('login')->with('message', 'Your Account Activated Successfully. Please Log In');
        }
        return Redirect::to('/');
    }

    private function setClientAgent(){
        $ip_address=Request::getClientIp(true);
        $client = AgentClient::where('ip_address','=',$ip_address)->where('type','=','agent')->get()->first();
        if(!$client->client_id){
            $client->client_id=Auth::user()->id;
            $client->save();
        }elseif($client->client_id!=Auth::user()->id){
            $client= new AgentClient;
            $client->client_id=Auth::user()->id;
            $client->ip_address=$ip_address;
            $client->agent_id=$this->agent->id;
            $client->type='agent';
            $client->save();
        }

        $fclient = AgentClient::where('ip_address','=',$ip_address)->where('type','=','finance')->get()->first();
        if(!$fclient->client_id){
            $fclient->client_id=Auth::user()->id;
            $fclient->save();
        }elseif($fclient->client_id!=Auth::user()->id){
            $fclient= new AgentClient;
            $fclient->client_id=Auth::user()->id;
            $fclient->ip_address=$ip_address;
            $fclient->agent_id=$this->finance_agent->id;
            $fclient->type='finance';
            $fclient->save();
        }
    }
    
}