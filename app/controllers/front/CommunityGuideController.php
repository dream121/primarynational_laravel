<?php

class CommunityGuideController extends FrontendController {
    protected $states;
    protected $cities;
    public function __construct(){
        parent::__construct();
        $this->setTitle('Real Estate Guides for Lexington');
        $this->selectMenu('community-guides');
        $this->setMenu('main_menu_ext_with_sub');
        $social_media = SocialMedia::all();
        View::share(compact('social_media'));
        $guide_list=Guide::lists('title','slug');
        View::share(compact('guide_list'));
        $this->states=array('Massachusetts','Rhode Island');
        $this->cities=array('Massachusetts'=>
                        array('Boston','Sharon','Brookline','Watertown','East Providence','Lexington','Newport','Pawtucket'),
                        'Rhode Island'=>
                        array('Braintree','Cranston','Franklin','Lincoln','Newton','Providence','Warwick','Woonsocket')
        );
    }

    public function getIndex()
    {
        $state=Input::has('state')?urldecode(Input::get('state')):null;
        $city=Input::has('city')?urldecode(Input::get('city')):null;
        $breadcrumbs=$this->states;
        if($state){
            Guide::where('state','=',$state);
            $breadcrumbs=$this->cities[$state];
            $guides = Guide::where('state','=',$state)->orderBy('created_at', 'desc')->paginate(10);
        }elseif($city){
            $breadcrumbs=array($city);
            $guides = Guide::where('city','=',$city)->orderBy('created_at', 'desc')->paginate(10);
        }else{
            $guides = Guide::orderBy('created_at', 'desc')->paginate(10);
        }
        return View::make('community_guide.index')->with(compact('guides','breadcrumbs'));
    }

    public function getView($slug){
        $guide = Guide::where('slug','=',$slug)->get()->first();
        $similer_guides=Guide::where('id','!=',$guide->id)->where('status','=','1')->where('state','=',$guide->state)->orderBy('created_at', 'desc')->take(3)->get();
        $recent_blogs=Guide::where('id','!=',$guide->id)->where('status','=','1')->orderBy('created_at', 'desc')->take(4)->get();
        $popular_blog=Guide::where('status','=','1')->where('id','!=',$guide->id)->take(4)->orderBy('hit_count', 'desc')->orderBy('created_at', 'desc')->get();
        return View::make('community_guide.view')->with(compact('guide','similer_guides','recent_blogs','popular_blog'));
    }

    private function _getCountByArea($area){
        $areas = array();
        Cache::forget('city_listing_array');

        if(Cache::has('city_listing_array')){
            $areas = Cache::get('city_listing_array');
        }else{

            $total_property_by_city = Property::select(array('city as name',DB::raw('COUNT(listing_id) as total_listing')))
                ->whereIn('city',$area)
                ->groupBy('city')->get()->toArray();

            Cache::put('city_listing_array', $total_property_by_city, 30);
            $areas = Cache::get('city_listing_array');
        }

        return $areas;
    }

}
