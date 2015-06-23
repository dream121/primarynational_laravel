<?php

class FeedbackController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Feedback');
    }
    
    public function getIndex()
    {
        $feedbacks = Feedback::with('Agent')->orderBy('recent_status','desc')->orderBy('created_at','desc')->paginate(20);
        return View::make('admin.feedback.index')->with(compact('feedbacks'));
    }
    public function getIndexByCat($cat,$new=0)
    {
        $type_title='Feedbacks';
        switch($cat){
            case "contact":
                $type_title="Contact Requests";
                break;
            case "buy":
                $type_title="Buy Requests";
                break;
            case "sell":
                $type_title="Sell Requests";
                break;
            case "finance":
                $type_title="Financial Requests";
                break;
            case "showing":
                $cat="request showing";
                $type_title="Request A Showing";
                break;
            case "ask":
                $cat="inquiry";
                $type_title="Ask An Agent Requests";
                break;
        }
        if($new)
            $feedbacks = Feedback::where('type','=',$cat)->where('recent_status','=',1)->orderBy('created_at','desc')->with('Agent')->paginate(20);
        else
            $feedbacks = Feedback::where('type','=',$cat)->orderBy('created_at','desc')->with('Agent')->paginate(20);

        return View::make('admin.feedback.index')->with(compact('feedbacks','type_title'));
    }
    public function getResetStatus($id,$status){
        $feedback=Feedback::find($id);
        $feedback->recent_status=$status;
        $feedback->save();
        return Redirect::back()->with('message','Operation Successful !');
    }
    public function getCreate()
    {
        return View::make('admin.feedback.create');
    }


    public function getShow($id)
    {
        $feedback  = Feedback::find($id);
        return View::make('admin.feedback.show')->with(compact('feedback'));
    }


    public function getEdit($id)
    {

        $agent  = Feedback::find($id);
        return View::make('admin.feedabck.edit')->with(compact('agent'));
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
      if(Feedback::destroy($id))
      {
        return Redirect::to('admin/feedback/index')
        ->with('success_msg', 'Feedback Deleted successfully');
    }
    else
    {
     return Redirect::to('admin/feedback/index')
     ->with('error_msg', 'Delete Operation Failed');
 }
}

}