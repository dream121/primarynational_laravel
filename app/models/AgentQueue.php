<?php

class AgentQueue extends Eloquent{

	protected $guarded = array();

    protected $table = 'agent_queues';



 	public function user()
    {
        return $this->belongsTo('User');
    }
 	public function agent()
    {
        return $this->belongsTo('Agent');
    }
 	public function financialAgent()
    {
        return $this->belongsTo('FinancialAgent');
    }

}