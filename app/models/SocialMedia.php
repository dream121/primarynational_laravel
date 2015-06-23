<?php

class SocialMedia extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';
    protected $type = 'social_media';
    protected $attributes = array(
	  'type' => 'social_media'
	);

    public static function rules($id=0)
    {
        return array(
            'title'=>'required',
            'link'=>'required|url'
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
