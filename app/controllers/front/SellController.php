<?php

class SellController extends FrontendController {
//    private $agent;
    public function __construct(){
        parent::__construct();
        $this->setTitle('Sell Your Home in Lexingtion!');
        $this->selectMenu('sell');
        $this->setMenu('main_menu_ext_with_sub');
        $agent=$this->agent;
        View::share(compact('agent'));
    }

    public function getIndex()
    {
        $buy_post=Sell::where('status','=',1)->first();
        if(@$this->agent->phone_number)
            $content = str_replace('000-000-0000',$this->agent->phone_number,$buy_post->content);
        else
            $content = $buy_post->content;

        return View::make('sell.index')->with(compact('content'));
    }

    public function postIndex(){
        $rules = array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email', // make sure the email is an actual email
        );

        // run the validation rules on the inputs from the form
        $validator = Validator::make(Input::all(), $rules);

        // if the validator fails, redirect back to the form
        if ($validator->fails()) {
            return Response::json(array(
                'success' => false,
                'errors' => $validator->errors()->toArray(),
                'message' => 'Request could not Sent Successfully',

            ), 200);
        } else {
            $input=Input::all();
            $input['type']='sell';
            $input['agent_id']=$this->agent->id;
            $input['user_id']=Auth::check()?Auth::user()->id:0;
            if ($feedback = Feedback::create($input)) {
                AgentQueue::create(array('user_id'=>Input::get('user_id'),'status'=>1));
                $cred['data'] = $input;
                $cred['to'] = $this->agent->email;
                $cred['receiver_name'] =  $this->agent->first_name." ".$this->agent->last_name;
                $cred['subject'] = "A Inquiry from ".Input::get('first_name')." ". Input::get('last_name')." for Sell";
                $cred['view'] = "emails.sell.request";
                $this->_sendEmail($cred);
                return Response::json(array('success' => true,'message'=>'Request Sent Successfully'), 200);

            } else {
                return Response::json(array(
                    'success' => false,
                    'message' => 'Request could not Sent Successfully',

                ), 200);
            }

        }
    }


}
