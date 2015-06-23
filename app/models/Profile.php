<?php

class Profile extends Eloquent{

	protected $guarded = array();

    protected $table = 'user_profiles';

    public static function rules()
    {
        return array(
            'name'=>'required'
        );
    }

 	public function user()
    {
        return $this->belongsTo('User');
    }

}