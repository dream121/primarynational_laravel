<?php

class MlsServer extends Eloquent{

	protected $guarded = array();

    protected $table = 'mls_servers';

//    public static function rules($id=0)
//    {
//        return array(
//            'name'=>'required',
//            'system_id'=>'required|unique:mls_servers,system_id,'.$id,
//        );
//    }

    public function property()
    {
        return $this->hasMany('Property', 'mls_system_id', 'system_id');
    }

    static public function getUpdateDate(){
        return MlsServer::max('updated_at');
    }
}