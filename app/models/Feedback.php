<?php

class Feedback extends Eloquent {

    protected $guarded = array();

    protected $table = 'requests';
    protected $type = '';
    protected $attributes = array(
	  'type' => ''
	);

    public function user()
    {
        return $this->belongsTo('User','user_id');
    }
    public function agent()
    {
        return $this->belongsTo('User','agent_id');
    }

//    public function newQuery($excludeDeleted = true)
//    {
//        $query = parent::newQuery();
//        $query->where('type', '=', $this->type);
//        return $query;
//    }
}
