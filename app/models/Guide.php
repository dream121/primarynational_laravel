<?php

class Guide extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';
    protected $type = 'guide';
    protected $attributes = array(
	  'type' => 'guide'
	);

    public static function rules($id=0)
    {
        return array(
            'title'=>'required',
            'slug'=>'unique:posts,slug,'.$id,
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
