<?php

class AccountController extends FrontendController {

	protected $viewBase = "account";

    public function __construct(){
        parent::__construct();
        $this->setTitle('Nick Ratlife Realty Team\'s Real Estate Agents');
        $this->selectMenu('account');
        $this->setMenu('main_menu_ext_with_sub');
    }

    public function getIndex()
    {

        $this->view('index');

    }

    public function postAccount(){
        
        $input = Input::all();
        $user = Auth::user();
        
        $user->first_name = $input['first_name'];
        $user->last_name = $input['last_name'];
        $user->phone_number = $input['phone'];
        $user->address_line1 = $input['address_line1'];
        $user->address_line2 = $input['address_line2'];
        $user->city = $input['city'];
        $user->state = $input['state'];
        $user->zip = $input['zip'];

        if($user->save())
            return Response::json(['success'=>true,'message'=>'Account information updated successfully']);
        else
            return Response::json(['error'=>true,'message'=>'Some error please check it out']);
    }

    public function postChangePassword(){
        
        $input = Input::all();
        
        $user = Auth::user();
        $rules = array(
            'current_password' => 'required|between:6,16',
            'new_password' => 'required|between:6,16|confirmed'
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
            return Response::json(['error'=>true,'message'=>$msg_str]);
        } 
        else 
        {
            if (!Hash::check(Input::get('current_password'), $user->password)) 
            {
                return Response::json(['error'=>true,'message'=>'Current password  does not match']);
            }
            else
            {
                $user->password = Hash::make(Input::get('new_password'));
                $user->save();
                return Response::json(['success'=>true,'message'=>'Password updated successfully']);
            }
        }

    }

    public function getNotification()
    {
    	$this->selectMenu('notification');
        $this->getSaveSearches();
    	$this->view('notification');
    }

    public function send_request()
    {
//        echo "sss";exit;
        $data = Input::all();
//        print_r($data);die;
        $rules = array(
            'email' => 'required|email', // make sure the email is an actual email
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => 'Something wrong!!!',

            ), 200);
        } else {
//            echo "sss";exit;
            $request['listing_id'] = $data['listing_id'];
            $request['time_to_reach'] = $data['date'];
            $request['time'] = $data['time'];
            $request['first_name'] = isset($data['first_name']) ? $data['first_name'] : '';
            $request['last_name'] = isset($data['last_name']) ? $data['last_name'] : '';
            $request['email'] = isset($data['email']) ? $data['email'] : '';
            $request['phone_number'] = isset($data['phone_number']) ? $data['phone_number'] : '';
            $request['comments'] = isset($data['question']) ? $data['question'] : '';
            $request['listing_id'] = $data['listing_id'];
            $request['agent_id'] = $this->agent->id;
            $request['user_id']=Auth::check()?Auth::user()->id:0;

//            $input=Input::all();
            $request['type'] = 'request showing';
            if ($feedback = Feedback::create($request)) {
//                echo "success";
                $agent = $this->agent;
                $address = $data['address'];
                Mail::send('emails.visitors.send_request_showing', $data, function ($message) use ($address, $agent) {
                    $message->from('russell_aub@yahoo.com', 'Russell')->to($agent->email, $agent->first_name . " " . $agent->last_name)->subject($address . ' : Showing Request Received');

                });

                return Response::json(array('success' => true), 200);
            } else {

                return Response::json(array('success' => false,'message'=> 'Request is not Sent Successfully'), 200);
            }
        }
    }
    public function postSaveSearch(){
        $validator = Validator::make(Input::all(), SearchHistory::rules());

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
                return Redirect::to('visitor/save-search')->with('message', 'Something wrong!!!')->withErrors($validator) // send back all errors to the login form
                ->withInput(Input::all()); // send back the input (not the password) so that we can repopulate the form
            }

        } else {

            // create our user data for the authentication
            $userdata = array(
                'search_name' => Input::get('search_name'),
                'search_link' => Input::get('search_link'),
                'search_type' => Input::get('search_type'),
                'email'       => Input::get('email'),
                'email_interval' => Input::get('email_interval'),
                'user_id' => Auth::id(),
                );

            // attempt to do the login
            if ($user = SearchHistory::create($userdata)) {
                if(Request::ajax())
                    return Response::json(array('success' => true,'message'=>'Current Search Saved Successfully'), 200);
                else
                    return Redirect::back()->with('message', 'Current Search Saved Successfully');

            } else {
                if(Request::ajax())
                    return Response::json(array(
                        'success' => false,
                        'message' => 'Could not Save Search. Try Again...',
                    ), 200);
                else
                    return Redirect::to('visitor/save-search')->with('message', 'Could not save data to the database. Please try again!!!')->withInput(Input::except('password'));
            }

        }

    }

    public function getSaveSearches(){
        if(Auth::check()){
            $save_searches=SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','search')->get();
//            $favorities=SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->lists('search_name');
            View::share('save_searches',$save_searches);
//            View::share('favorities',$favorities);
        }
    }

    public function getFavorites(){
        if(Auth::check()){
            $favorities=SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->lists('search_name');
            return Response::json($favorities, 200);
        }
    }

    public function postSaveFavorite(){


        // create our user data for the authentication
        $userdata = array(
            'search_name' => Input::get('search_link'),
            'search_link' => Input::get('search_link'),
            'search_type' => 'favorite',
            'email'       => Auth::user()->email,
            'user_id' => Auth::id(),
            );

        // attempt to do the login
        if ($user = SearchHistory::create($userdata)) {
            $favorit_count=count(SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->distinct()->lists('search_name'));
            if(Request::ajax())
                return Response::json(array('success' => true,'count'=>$favorit_count), 200);
            else
                return Redirect::back()->with('message', 'Current Favorite Saved Successfully');

        } else {
            if(Request::ajax())
                return Response::json(array(
                    'success' => false,
                    'message' => 'Could not Save Favorite. Try Again...',

                ), 200);
            else
                return Redirect::to('visitor/save-favorite')->with('message', 'Could not save data to the database. Please try again!!!')->withInput(Input::except('password'));
        }

    }

    public function getDeleteNotification($id){

        if ($user = SearchHistory::destroy($id)) {
            if(Request::ajax())
                return Response::json(array('success' => true), 200);
            else
                return Redirect::back()->with('success_msg', 'Current Favorite Deleted Successfully');

        } else {
            if(Request::ajax())
                return Response::json(array(
                    'success' => false,
                    'message' => 'Could not Delete Save Search. Try Again...',

                ), 200);
            else
                return Redirect::back()->with('error_msg', 'Could not Delete data from the Database. Please try again!!!')->withInput(Input::except('password'));
        }

    }
    public function postDeleteFavorite(){

        if ($user = SearchHistory::where('search_name', '=', Input::get('search_link'))->where('user_id', '=', Auth::id())->delete()) {
            $favorit_count=count(SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->distinct()->lists('search_name'));
            if(Request::ajax())
                return Response::json(array('success' => true,'count'=>$favorit_count), 200);
            else
                return Redirect::back()->with('message', 'Current Favorite Deleted Successfully');

        } else {
            if(Request::ajax())
                return Response::json(array(
                    'success' => false,
                    'message' => 'Could not Delete Favorite. Try Again...',

                ), 200);
            else
                return Redirect::to('visitor/delete-favorite')->with('message', 'Could not Delete data from the Database. Please try again!!!')->withInput(Input::except('password'));
        }

    }

    public function postInquiry(){
//        $this->agent=$this->getCurrentAgent();
        $rules = array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email', // make sure the email is an actual email
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Response::json(array('message'=>'Data validation failed','errors'=>$validator->messages(),'message' => 'Request could not Sent Successfully'));
        } else {
            $input=Input::all();
            $input['agent_id']=$this->agent->id;
            $input['type']='inquiry';
            if ($feedback = Feedback::create($input)) {
                $cred['data'] = $input;
                $cred['to'] = $this->agent->email;
                $cred['receiver_name'] =  $this->agent->first_name." ".$this->agent->last_name;
                $cred['subject'] = "A Inquiry from ".Input::get('first_name')." ". Input::get('last_name');
                $cred['view'] = "emails.contact.inquiry";
                $this->_sendEmail($cred);

                if(Request::ajax())
                    return Response::json(array('success' => true,'message'=>'Your Request Sent Successfully. Reply you soon...'), 200);
                else
                    return Redirect::back()->with('message', 'Your Request Sent Successfully. Reply you soon...');

            } else {

                if(Request::ajax())
                    return Response::json(array(
                        'success' => false,
                        'message' => 'Could not Sent Your Inquiry. Please Try Again...',

                    ), 200);
                else
                    return Redirect::to('visitor/inquiry')->with('message', 'Could not Sent Your Inquiry. Please Try Again!!!');
            }

        }
    }

}
