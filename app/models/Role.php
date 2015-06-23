<?php

class Role extends Eloquent{

	protected $guarded = array();

    protected $table = 'roles';

    public static function rules()
    {
        return array(
            'name'=>'required'
        );
    }

 	public function user()
    {
        return $this->hasMany('User');
    }

}