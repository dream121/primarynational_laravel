<?php

class Post extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';

	public static $rules = array(
		'title'=>'required',
		'slug'=>'required',
		'content'=>'required'
		);

}
