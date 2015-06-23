<?php

class CommentController extends AdminController {

    public function __construct(){
        View::share('page_title', 'Manage Comments');
    }
    
    public function getIndex($recent=0)
    {
        if($recent){
            $comments = Comment::where('recent_status','=',1)->with('blog')->orderBy('recent_status','desc')->orderBy('created_at','desc')->paginate(20);
        }else{
            $comments = Comment::with('blog')->orderBy('recent_status','desc')->orderBy('created_at','desc')->with('blog')->paginate(20);
        }
        return View::make('admin.comment.index')->with(compact('comments'));
    }

    public function getResetStatus($id,$status){
        $comment=Comment::find($id);
        $comment->recent_status=$status;
        $comment->save();
        return Redirect::back()->with('message','Operation Successful !');
    }
    public function getCreate()
    {
        return View::make('admin.feedback.create');
    }


    public function getShow($id)
    {
        $comment  = Comment::with('blog')->find($id);
        return View::make('admin.comment.show')->with(compact('comment'));
    }


    public function getEdit($id)
    {

        $agent  = Feedback::find($id);
        return View::make('admin.feedabck.edit')->with(compact('agent'));
    }


    public function getActivate($id,$status='no')
    {
        $comment = Comment::find($id);
        $comment->approved   =($status==='yes')?1:0;
        $comment->save();

        return Redirect::back()
        ->with('success_msg', 'Comment Updated successfully');
    }

    public function getDelete($id)
    {
      if(Comment::destroy($id))
      {
        return Redirect::back()
        ->with('success_msg', 'Comment Deleted successfully');
    }
    else
    {
     return Redirect::back()
     ->with('error_msg', 'Delete Operation Failed');
 }
}
    public function getApproval($id,$approval=0)
    {
        $comment = Comment::find($id);
        $comment->approved = $approval;
        $comment->save();
        return Redirect::back()
            ->with('success_msg', 'Comment Approved successfully');
    }

}