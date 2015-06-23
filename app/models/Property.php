<?php

class Property extends Eloquent{

	protected $guarded = array();

    protected $table = 'properties';

    public static function rules()
    {
        return array(
            'listing_id'=>'required'
        );
    }

    public function MlsServer()
    {
        return $this->belongsTo('MlsServer','mls_system_id','system_id');
    }

}