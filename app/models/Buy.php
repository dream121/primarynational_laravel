<?php

class Buy extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';
    protected $type = 'buy';
    protected $attributes = array(
        'type' => 'buy'
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
