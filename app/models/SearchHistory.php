<?php

class SearchHistory extends Eloquent {

    protected $guarded = array();

    protected $table = 'user_search_histories';
    
    public static function rules($id=0){
        return array(
            'email' => 'required|email'
            );
    }
    public function user()
    {
        return $this->belongsTo('User','user_id');
    }
    /*public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }*/
}
