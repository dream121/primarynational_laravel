<?php

class FrontendController extends BaseController {
    protected $agent;
    protected $finance_agent;
    public function __construct(){
        parent::__construct();
        $this->selectMenu();
        $this->setTitle();
        $this->setMenu();
        $this->setFooter();
        $this->getSocialIcon();
        $this->getGuides();
        $this->getAboutUs();
        $this->getFavoritesAll();
        $this->getLastUpdateMls();
        $this->getStatus();
        if(Session::get('assigned_agent')==true){
            $this->agent=User::with('Profile')->find(Session::get('agent'));
        }else{
            $this->agent=$this->_getCurrentAgent();
            if($this->agent){
                $this->setAgentClient();
                Session::put('assigned_agent',true);
                Session::put('agent',$this->agent->id);
            }else{
                Session::put('assigned_agent',false);
            }

        }
        //financial agent
        if(Session::get('assigned_finance_agent')){
            $this->finance_agent=User::with('Profile')->find(Session::get('finance_agent'));
        }else{
            $this->finance_agent=$this->_getCurrentFinancialAgent();
            if($this->finance_agent){
                $this->setFinancialAgentClient();
                Session::put('assigned_finance_agent',true);
                Session::put('finance_agent',$this->finance_agent->id);
            }else{
                Session::put('assigned_finance_agent',true);
            }

        }
    }

    public function setAgentClient(){
        $client_id=Auth::check()?Auth::id():null;
        $ip_address=Request::getClientIp(true);

        if(!empty($this->agent) && $client_id){
            $client = AgentClient::where('client_id','=',$client_id)->where('type','=','agent')->get()->first();
        }elseif(!empty($this->agent) && $ip_address){
            $client = AgentClient::where('ip_address','=',$ip_address)->where('type','=','agent')->get()->first();

        }
        if(!isset($client->id) && $this->agent->role_id==3){
            $agent_client= new AgentClient();
            $agent_client->client_id=$client_id;
            $agent_client->ip_address=$ip_address;
            $agent_client->type="agent";
            $agent_client->agent_id=$this->agent->id;
            if($agent_client->save()){
                $this->agent->client_served=$this->agent->client_served+1;
                $this->agent->save();
            }
        }

    }

    public function _getCurrentAgent(){
        
        if(Session::get('assigned_agent')){
            return Session::get('agent');
        }
        if(Auth::check()){
            $client = AgentClient::where('client_id','=',Auth::id())->where('type','=','agent')->get()->first();
        }else{
            $client = AgentClient::where('ip_address','=',Request::getClientIp(true))->where('type','=','agent')->get()->first();

        }
        if(isset($client->id)){
            $agent=Agent::with('Profile')->find($client->agent_id);
            return $agent;
        }else{
            $agent=Agent::with('Profile')->whereRaw('client_serve_limit > client_served')->orderBy('agent_order', 'asc')->get()->first();
            if(!isset($agent->id)){
                if(Agent::count()){
                    DB::table('users')
                    ->where('role_id','=','3')
                    ->update(array('client_served' => 0));
                    $agent=Agent::with('Profile')->whereRaw('client_serve_limit > client_served')->orderBy('agent_order', 'asc')->get()->first();
                   if(isset($agent->id)){
                        return $agent;
                    }else{
                        return User::with('Profile')->where('role_id','=',1)->get()->first();
                    }
                }else{
                    return User::with('Profile')->where('role_id','=',1)->get()->first();
                }

            }else{
                return $agent;
            }
        }
    }

    public function setFinancialAgentClient(){
        $client_id=Auth::check()?Auth::id():null;
        $ip_address=Request::getClientIp(true);

        if(!empty($this->finance_agent) && $client_id){
            $client = AgentClient::where('client_id','=',$client_id)->where('type','=','finance')->get()->first();
        }elseif(!empty($this->finance_agent) && $ip_address){
            $client = AgentClient::where('ip_address','=',$ip_address)->where('type','=','finance')->get()->first();
        }
         if(!isset($client->id) && $this->finance_agent->role_id==5){
            $agent_client= new AgentClient();
            $agent_client->client_id=$client_id;
            $agent_client->ip_address=$ip_address;
            $agent_client->type="finance";
            $agent_client->agent_id=$this->finance_agent->id;
            if($agent_client->save()){
                $this->finance_agent->client_served=$this->finance_agent->client_served+1;
                $this->finance_agent->save();
            }
        }

    }

    public function _getCurrentFinancialAgent(){
        if(Session::get('assigned_fiannce_agent')){
            return Session::get('finance_agent');
        }
        if(Auth::check()){
            $client = AgentClient::where('client_id','=',Auth::id())->where('type','=','finance')->get()->first();
        }else{
            $client = AgentClient::where('ip_address','=',Request::getClientIp(true))->where('type','=','finance')->get()->first();
        }
        if(isset($client->id)){
            $agent=FinancialAgent::with('Profile')->find($client->agent_id);
            return $agent;
        }else{
            $agent=FinancialAgent::with('Profile')->whereRaw('client_serve_limit > client_served')->orderBy('agent_order', 'asc')->get()->first();
            if(!isset($agent->id)){
                if(FinancialAgent::count()){
                    DB::table('users')
                    ->where('role_id','=','5')
                    ->update(array('client_served' => 0));
                    $agent=FinancialAgent::with('Profile')->whereRaw('client_serve_limit > client_served')->orderBy('agent_order', 'asc')->get()->first();
                    if(isset($agent->id)){
                        return $agent;
                    }else{
                        return User::with('Profile')->where('role_id','=',1)->get()->first();
                    }
                }else{
                    return User::with('Profile')->where('role_id','=',1)->get()->first();
                }
            }else{
                return $agent;
            }
        }
    }

    public function selectMenu($menu=''){
        View::share('selected_menu', $menu);
    }

    protected function setSubmenu($name = ''){
        View::share('sub_menu',$name);
    }

    protected function setTitle($title='Home Page'){
        View::share('title', $title);
    }

    protected function setMenu($name='main_menu'){
        View::share('main_menu','elements.'.$name);
    }

    protected function setFooter($name='footer'){
        View::share('main_footer','elements.'.$name);
    }

    private function getSocialIcon(){

        if(Cache::has('social_icons')){            
            $social_icons = Cache::get('social_icons');
        }else{
            $social_icons = SocialMedia::where('status','=',1)->get();
            Cache::put('social_icons', $social_icons, 30);
        
            $social_icons = Cache::get('social_icons');
        }
        
        View::share(compact('social_icons'));
    }

    private function getGuides(){

        if(Cache::has('guide_lists')){
            $guide_lists = Cache::get('guide_lists');
        }else{

            $guide_lists = Guide::where('status','=',1)->select('title','slug')->take(6)->get();
            Cache::put('guide_lists', $guide_lists, 6);
            $guide_lists = Cache::get('guide_lists');
        }

        View::share(compact('guide_lists'));
    }

    private function getAboutUs(){

         if(Cache::has('about_us')){            
            $about_us = Cache::get('about_us');
        }else{

            $about_us = Page::where('slug','=','about-us')->get()->first();
            Cache::put('about_us', $about_us, 30);
            $about_us = Cache::get('about_us');
        }

        View::share(compact('about_us'));
    }

    protected  function _sendEmail($cred){
        Mail::send($cred['view'], $cred['data'], function($message) use($cred)
        {
            if(isset($cred['receiver_name'])){
                $message->to($cred['to'],$cred['receiver_name'])->subject($cred['subject']);
            }else{
                $message->to($cred['to'])->subject($cred['subject']);
            }

        });
    }

    protected function getFavoritesAll(){
        if(Auth::check()){
            $fav_listings=SearchHistory::where('search_type','=','favorite')->where('user_id','=',Auth::id())->distinct()->lists('search_name');
            View::share('fav_listings',$fav_listings);
            View::share('favorites_count',count($fav_listings));
        }
    }

    protected function getLastUpdateMls(){
        $updated_at=new DateTime(MlsServer::getUpdateDate());
        $current_date=new DateTime(date('Y-m-d h:i:s',time()));
        View::share('update_interval',date_diff($current_date,$updated_at));
    }

    protected function getStatus(){
        $status=Property::select('status')->distinct('status')->lists('status','status');
        View::share('status_all',$status);
    }
}