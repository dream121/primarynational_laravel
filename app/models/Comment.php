<?php

class Comment extends Eloquent {

    protected $guarded = array();

    protected $table = 'comments';
    
    public static function rules(){
        return array(
            'author_name'=>'required',
            'author_email'=>'required',
            'comment'=>'required'
            );
    }
    public function blog()
    {
        return $this->belongsTo('Blog','post_id');
    }
    public function user()
    {
        return $this->belongsTo('User','user_id');
    }
    public function profile(){
        return $this->hasManyThrough('Profile', 'User');
    }
    /*public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }*/
}
