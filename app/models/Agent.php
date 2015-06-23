<?php

class Agent extends Eloquent {

    protected $guarded = array();

    protected $table = 'users';
    protected $role_id = 3;
    protected $attributes = array(
        'role_id' => 3
    );

    public static function rules($id=0)
    {
        return array(
            'first_name'=>'required',
            'last_name'=>'required',
            'email' => 'required|email|unique:users,email,'.$id
        );
    }

    public function profile(){
        return $this->hasOne('Profile','user_id');
    }

    public function feedback(){
        return $this->hasmany('Feedback','agent_id');
    }

    public function agentQueue(){
        return $this->hasMany('AgentQueue','user_id');
    }
    public function agentClient(){
        return $this->hasMany('AgentClient','agent_id');
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
