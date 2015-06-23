<?php

class Page extends Eloquent {

    protected $guarded = array();

    protected $table = 'pages';

	public static function rules($id=0)
    {
        return array(
            'title'=>'required',
            'slug'=>'unique:pages,slug,'.$id,
            'details'=>'required'
        );
    }


}
