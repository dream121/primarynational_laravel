<?php

class HomeController extends FrontendController {

    public function __construct(){
        parent::__construct();
        $this->setTitle('Home page');
        
    }
    
    public function getIndex()
    {

        $top_areas = $this->_getTopArea();
        $total_property = $this->_getTotalProperty();
        $home_banner = Banner::getBanners();
        $welcome_note = WelcomeNote::get()->first();
        return View::make('home.index')->with(compact('home_banner','welcome_note','top_areas','total_property'));

    }

    private function _getTopArea(){
        $_top_areas = array(
            'Cranston',
            'East Providence',
            'Newport',
            'Pawtucket',
            'Providence',
            'Warwick',
            'Woonsocket',
            'Lincoln',
            'Braintree',
            'Sharon',
            'Boston',
            'Brookline',
            'Lexington',
            'Franklin',
            'Watertown',
            'Newton'
        );
        $top_areas = array();
        // Cache::forget('city_listing_array');

        if(Cache::has('city_listing_array')){
            $top_areas = Cache::get('city_listing_array');
        }else{

            $total_property_by_city = Property::select(array('city as name',DB::raw('COUNT(listing_id) as total_listing')))
            ->whereIn('city',$_top_areas)
            ->orderBy('state', 'DESC')
            ->groupBy('city')->get()->toArray();

            while ($value = current($total_property_by_city)) {
                if(in_array($value['name'],$_top_areas)){
                    $key = array_search($value['name'], $_top_areas);
                    $new_array[$key] = $value;
                }
                next($total_property_by_city);
            }
            ksort($new_array);
            Cache::put('city_listing_array', $new_array, 30);
            $top_areas = Cache::get('city_listing_array');
        }

        return $top_areas;
    }

    private function _getTotalProperty(){
        $total_property = 0;
        if(Cache::has('total_property')){
            $total_property = Cache::get('total_property');
        }else{

            $num_property = Property::select('listing_id')
            ->get()->count();

            Cache::put('total_property', $num_property, 30);
            $total_property = Cache::get('total_property');
        }
        return $total_property;
    }

}
