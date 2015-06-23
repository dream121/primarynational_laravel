<?php

class Subscriber extends Eloquent {

    protected $guarded = array();

    protected $table = 'subscribers';

    public static function rules($id=0)
    {
        return array(
            'email' => 'required|email|unique:subscribers,email,'.$id
        );
    }



}
