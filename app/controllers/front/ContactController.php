<?php

class ContactController extends FrontendController {

    public function __construct(){
        parent::__construct();
        $this->setTitle('Contact Us');
        $this->selectMenu('contact-us');
        $this->setMenu('main_menu_ext_with_sub');
    }

    public function getIndex()
    {
        $contact_us = ContactUs::get()->first();
        return View::make('contact.index')->with(compact('contact_us'));
    }

    public function postComment(){
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
            $input['type']='contact';
            $input['user_id']=Auth::check()?Auth::user()->id:0;
            if ($feedback = Feedback::create($input)) {
                $this->__sendEmail($input);
                return Response::json(array('success' => true,'message'=>'Your Request Sent Successfully'), 200);

            } else {

                return Response::json(array('success' => false,'message'=>'Request could not Sent Successfully'), 200);
            }

        }
    }

    private function __sendEmail($data){
        Mail::send('emails.contact.request', $data, function($message)
        {

            $message->to(Config::get('mail.from.address'),Config::get('mail.from.name'))->subject('Request for Contact');
        });
    }

}
