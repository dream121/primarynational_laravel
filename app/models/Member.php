<?php

class Member extends Eloquent {

    protected $guarded = array();

    protected $table = 'users';
    protected $role_id = 4;
    protected $attributes = array(
        'role_id' => 4
    );

    public static function rules($id=0)
    {
        return array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email|unique:users,email,'.$id,
            'phone_number' => 'required',
        );
    }

    public function profile(){
        return $this->hasOne('Profile','user_id');
    }

    public function role()
    {
        return $this->belongsTo('Role','role_id');
    }

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('role_id', '=', $this->role_id);
        return $query;
    }

}
