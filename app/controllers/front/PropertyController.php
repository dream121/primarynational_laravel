<?php

class PropertyController extends FrontendController {

    public function __construct(){
        parent::__construct();
        $this->setTitle('Properties of Primarynational');
        $this->setMenu('main_menu_extended');
        $this->uri = Request::getQueryString();
        View::share('uri',$this->uri);
        $agent=$this->agent;
        View::share(compact('agent'));

    }

    public function getShow($id,$slug)
    {

        $this->setSubmenu('');
        //unsigned individula visitor hit count
        $is_favorite=0;
        if(!Auth::check()){
//            Session::put("more_details_counter",Session::get("more_details_counter",0));
            $counter=Cookie::get('more_details_counter')?Cookie::get('more_details_counter')+1:1;
            Cookie::forever('more_details_counter', $counter);
        }else{
            $is_favorite=SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->where('search_name','=',$id)->count();
        }
        if(Cache::has('property-'.$id) && $is_favorite>0){
            $property = Cache::get('property-'.$id);
            $property->favorite=1;
        }else{
            

            $property = Property::where('listing_id','=',$id)->get()->first();
            // updating the visitor count information
            $property->hit_count = (int)$property->hit_count+1;
            $property->save();    

            // this section is to get the property which will be be almost similar to the listing  
            $max_price = (int)$property->list_price+25000;
            $min_price = (int)$property->list_price<25000 ? 0:(int)$property->list_price-25000;
            
            $property = $this->_prepareData($property);
            $property->favorite=0;
            if(Auth::check()){
                $property->favorite=SearchHistory::where('user_id','=',Auth::id())->where('search_type','=','favorite')->where('search_name','=',$property->listing_id)->count();
            }
//            print_r($has_fav);

            $similar_properties = Property::where('property_type','=',$property->property_type)
            ->where('city','=',$property->city)
            ->whereBetween('list_price', array($min_price,$max_price))
            ->where('listing_id','!=',$id)
            ->get();

            if (!$similar_properties->isEmpty()) { 
                foreach ($similar_properties as $key => $value) {
                    $similar_properties[$key] = $this->_prepareData($value);
                }
            }
            
            $property->like_to_see = $similar_properties;
            $property->favorite = $is_favorite;
            Cache::put('property-'.$id, $property, 300);
        
            $property = Cache::get('property-'.$id);

        }

            $this->setTitle($property->full_address);       

        if (Request::ajax()){
            return View::make('property.ajaxDetails')->with(compact('property'));
        }
        else{
            return View::make('property.show')->with(compact('property'));    
        }
    }

    public function getSimilar($id){
        $property = Property::select(array('listing_id','property_type','list_price','city'))->where('listing_id','=',$id)->get()->first();
        $max_price = (int)$property->list_price+50000;
        $min_price = (int)$property->list_price<50000 ? 0:(int)$property->list_price-50000;
        $properties = Property::where('property_type','=',$property->property_type)
        ->where('city','=',$property->city)
        ->whereBetween('list_price', array($min_price,$max_price))
        ->where('listing_id','!=',$id)
        ->get();

        foreach($properties as $key=>$property){
            $properties[$key] = $this->_prepareData($property);
        }
        return View::make('property.similar')->with(compact('properties'));
    }

    public function getSuggest()
    {

        $search_string = trim(Input::get('query'));
        $json = array();
        $result = Property::select('id','listing_id','street_number','street_name','city','zip_code')
        ->where('street_number','like','%'.$search_string.'%')
        ->orWhere('street_name','like','%'.$search_string.'%')
        ->orWhere('city','like','%'.$search_string.'%')
        ->get()->toArray();
        $i = 0;
        foreach($result as $key=>$property){
            $i++;
            $json[$i]['value'] = $property['street_number']. ' '.$property['street_name'].' '.$property['city'];
            $json[$i]['data'] = array('category'=>'Location');
        }
        foreach($result as $key=>$property){
            $json[$property['city']]['value'] = $property['city'];
            $json[$property['city']]['data'] = array('category'=>'City');
        }
       
        return array('suggestions'=>$json);
        
    }

    private function _prepareData($property)
    {

        $property->photo_available = true;
        $property->photos = array();   
        if($property->photos_count>0){
            $photos = array();
            for($i=1;$i<=$property->photos_count;$i++){
                $photos[] = 'http://images.primarynational.com/'.$property->mls_system_id.'/'.$property->listing_key.'_'.$i.'.jpg';
            }
            $property->photos = $photos;
            $property->main_photo = 'http://images.primarynational.com/'.$property->mls_system_id.'/'.$property->listing_key.'_1.jpg';
        }
        else{
            $property->photo_available = null;
            $property->main_photo = url('/photos/image-not-available.jpg');
        }

        if(empty($property->unparsed_address)){
           $property->unparsed_address =  $property->street_number.' '.$property->street_name;
        }
        if($property->latitude=='' || $property->longitude=='' ){
            $property->latitude = false;
            $property->longitude = false;
        }

        $property->full_address = $property->unparsed_address.', '.$property->state.' ' .$property->zip_code;
        
        $property->status_icon = $this->_getStatusIcon($property);
        $property->url = url('property/'.$property->listing_id.'/'.Str::slug($property->unparsed_address.' '.$property->state.' ' .$property->zip_code));
        $property->formatedPrice = '$'.number_format($property->list_price);
        $property->mls_logo = url('assets/img/'.$property->mls_system_id.'.jpg');
        
        return $property;

    }

    public function suggest()
    {

        $this->setSubmenu('');
        $search_query=Input::get('query');
        $query_type=Input::has('query_type')?Input::get('query_type'):null;
        $search_query=strtolower($search_query);
        if(!$query_type){
            $properties = Property::select(array('street_number','street_name','city','zip_code'))
                ->where('street_number', 'like', '%' . $search_query . '%')
                ->orWhere('street_name', 'like', '%' . $search_query . '%')
                ->orWhere('city', 'like', '%' . $search_query . '%')
                ->orWhere('zip_code', 'like', '%' . $search_query . '%')
                ->orWhere('listing_id', '=',  $search_query)
                ->get();
        }else{
            switch($query_type){
                case 'city':
                    $properties = Property::select(array('city'))
                        ->Where('city', 'like', '%' . $search_query . '%')
                        ->get();
                    break;
                case 'listing':
                    $properties = Property::select(array('listing_id'))
                        ->Where('listing_id', 'like', '%' . $search_query . '%')
                        ->get();

                    break;
                case 'address':
                    $properties = Property::select(array('street_number','street_name'))
                        ->where('street_number', 'like', '%' . $search_query . '%')
                        ->orWhere('street_name', 'like', '%' . $search_query . '%')
                        ->get();

                    break;
                case 'zipcode':
                    $properties = Property::select(array('zip_code'))
                        ->Where('zip_code', 'like', '%' . $search_query . '%')
                        ->get();
                    break;
                default:
                    $properties = Property::select(array('street_number','street_name','city','zip_code','listing_id'))
                        ->where('street_number', 'like', '%' . $search_query . '%')
                        ->orWhere('street_name', 'like', '%' . $search_query . '%')
                        ->orWhere('city', 'like', '%' . $search_query . '%')
                        ->orWhere('zip_code', 'like', '%' . $search_query . '%')
                        ->orWhere('listing_id', '=',  $search_query)
                        ->get();
            }
        }
        $suggestions=array();

        foreach($properties as $key=>$property){
            if(preg_match("/".$search_query."/i",strtolower($property->street_number))||preg_match("/".$search_query."/i",strtolower($property->street_name))){
                $tmp['address'][$property->street_number." ".$property->street_name]=$property->street_number." ".$property->street_name;
            }
            if(preg_match("/".$search_query."/i",strtolower($property->city))){
                $tmp['city'][$property->city]=$property->city;
            }
            if(preg_match("/".$search_query."/i",strtolower($property->zip_code))){
                $tmp['zip_code'][$property->zip_code]=$property->zip_code;
            }
            if(preg_match("/".$search_query."/i",strtolower($property->listing_id))){
                $tmp['listing'][$property->listing_id]=$property->listing_id;
            }
        }
        if(isset($tmp['address'])){
            foreach($tmp['address'] as $address){
                $suggestions[]= array('value'=>$address,'data'=>array('category'=>'Address'));
            }
        }
        if(isset($tmp['city'])){
            foreach($tmp['city'] as $city)
                $suggestions[]= array('value'=>$city,'data'=>array('category'=>'City'));
        }
        if(isset($tmp['zip_code'])){
            foreach($tmp['zip_code'] as $zip_code)
                $suggestions[]= array('value'=>$zip_code,'data'=>array('category'=>'Zip Code'));
        }
        if(isset($tmp['listing'])){
            foreach($tmp['listing'] as $listing)
                $suggestions[]= array('value'=>$listing,'data'=>array('category'=>'Listing'));
        }
        $result=array(
            'query'=>$search_query,
            'suggestions'=>$suggestions
        );
        return json_encode($result);
    }

    private function _getStatusIcon($property)
    {
        if(in_array($property->status, array('active','Active')))
            $status_icon = url('assets/img/icons/status/active.png');
        elseif(in_array($property->status, array('New','Active New')))
            $status_icon = url('assets/img/icons/status/new.png');
        elseif(in_array($property->status, array('Sold','sold')))
            $status_icon = url('assets/img/icons/status/sold.png');
        elseif(in_array($property->status, array('Price Changed')))
            $status_icon = url('assets/img/icons/status/price-changed.png');
        elseif(in_array($property->status, array('Back on Market')))
            $status_icon = url('assets/img/icons/status/back-on-market.png');
        elseif(in_array($property->status, array('Extended')))
            $status_icon = url('assets/img/icons/status/extended.png');
        else
            $status_icon = null;

        return $status_icon;
        
    }

}