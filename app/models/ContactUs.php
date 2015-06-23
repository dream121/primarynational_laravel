<?php

class ContactUs extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';
    protected $type = 'contact_us';
    protected $attributes = array(
	  'type' => 'contact_us'
	);

    public static function rules($id=0)
    {
        return array(
            'title'=>'required',
            'content'=>'required'
        );
    }

    public function user()
    {
        return $this->belongsTo('User','author_id');
    }

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }
}
