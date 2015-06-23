<?php

class ListingController extends BaseController
{

    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function index()
    {
        $input = Input::all();
        $limit = isset($input['limit']) ? $input['limit'] : 0; 
        
        $url = $_SERVER["HTTP_REFERER"];
        $url_arr = explode('/', $url);
        $map_arr = $url_arr[count($url_arr)-1];
        $map_key = explode('?', $map_arr)[0];

        if($map_key =="map"){
            if($limit == 0 || $limit > 100 ){
                $limit = 6000;
            }
        }
            
        $fav    =   isset($input['favs'])? $input['favs']:'';
        $status = isset($input['status']) && $input['status']!='any' ? urldecode($input['status']) : '';
        $min_price = isset($input['min_price']) ? $input['min_price'] : 'any';
        $max_price = isset($input['max_price']) ? $input['max_price'] : 'any';
        $price = isset($input['price']) ? $input['price'] : '';
        $sort = isset($input['sort']) ? $input['sort'] : '';
        $OfficeMLS = isset($input['OfficeMLS']) ? explode(",",$input['OfficeMLS']) : '';
        $city = isset($input['city']) ? urldecode($input['city']) : '';
        $nelat = isset($input['nelat']) ? (float)$input['nelat'] : '';
        $nelng = isset($input['nelng']) ? (float)$input['nelng'] : '';
        $swlat = isset($input['swlat']) ? (float)$input['swlat'] : '';
        $swlng = isset($input['swlng']) ? (float)$input['swlng'] : '';
        $address = isset($input['address']) ? urldecode($input['address']) : '';
        $street_no=!empty($address) ? explode(" ", $address)[0]:'';
        $street_name=!empty($address) ? substr($address, strpos($address," ")):'';
        $beds = isset($input['beds']) ? $input['beds'] : 'any';
        $baths = isset($input['baths']) ? $input['baths'] : 'any';
        $zip_code = isset($input['zip_code']) ? $input['zip_code'] : '';
        $property_types = isset($input['types']) ? explode(",",urldecode($input['types'])) : array();
        $minsqft = isset($input['minsqft']) ? $input['minsqft'] : '';
        $maxsqft = isset($input['maxsqft']) ? $input['maxsqft'] : '';
        $minacres = isset($input['minacres']) ? $input['minacres'] : '';
        $maxacres = isset($input['maxacres']) ? $input['maxacres'] : '';
        $minstories = isset($input['minstories']) ? $input['minstories'] : '';
        $maxstories = isset($input['maxstories']) ? $input['maxstories'] : '';
        $minyearbuilt = isset($input['minyearbuilt']) ? $input['minyearbuilt'] : '';
        $maxyearbuilt = isset($input['maxyearbuilt']) ? $input['maxyearbuilt'] : '';
        $mingaragespace = isset($input['mingaragespace']) ? $input['mingaragespace'] : '';
        $maxgaragespace = isset($input['maxgaragespace']) ? $input['maxgaragespace'] : '';
        $dayson = isset($input['dayson']) && $input['dayson']!='any'? $input['dayson'] : '';
        $pricereduce = isset($input['pricereduce']) ? $input['pricereduce'] : '';
        $features = isset($input['features']) ? explode(",",urldecode($input['features'])) : array();
//        print_r($features);die;

        if (in_array($status, array('active', 'A', 'act'))) {
            $status = 'active';
        }

        if (in_array($status, array('sold', 'S', 'sld'))) {
            $status = 'sold';
        }

        $query = new Listing();

        $query = Listing::where('status', 'like', '%' . $status . '%');
        if ($city)
            $query->where('city','=',urldecode($city));

      
        if($nelng && $swlng && $nelng<$swlng)
            $query->whereBetween('longitude',array($nelng,$swlng));
        if($nelng && $swlng && $nelng>$swlng)
            $query->whereBetween('longitude',array($swlng,$nelng)); 
        

        if($nelat && $swlat && $nelat<$swlat)
            $query->whereBetween('latitude',array($nelat,$swlat));
        if($nelat && $swlat && $nelat>$swlat)
            $query->whereBetween('latitude',array($swlat,$nelat));        

        switch($sort){
            case 'listprice':
                $query->orderBy('list_price', 'DESC');
                break;
            case 'listprice_asc':
                $query->orderBy('list_price', 'ASC');
                break;
            case 'popular':
                $query->where('hit_count','>=','5');
                $query->orderBy('hit_count','DESC');
                break;
            case 'bedrooms':
                $query->orderBy('bedrooms', 'DESC');
                break;
            case 'fullbaths':
                $query->orderBy('full_baths', 'DESC');
                break;
            case 'yearbuilt':
                $query->orderBy('year_built', 'DESC');
                break;
            case 'yearbuilt_asc':
                $query->orderBy('year_built', 'asc');
                break;
            case 'imported_asc':
                $query->orderBy('imported_at', 'asc');
                break;
            default:
                $query->orderBy('imported_at', 'desc');
                break;
        }

        if ($min_price !='' && $min_price !='any')
            $query->where('list_price', '>=', $min_price);
        if ($max_price != '' && $max_price != 'any')
            $query->where('list_price', '<=', $max_price);
        if ($price)
            $query->where('list_price', '>=', $price);

        if ($minsqft !='' && $minsqft !='any')
            $query->where('lot_size', '>=', $minsqft);
        if ($maxsqft != '' && $maxsqft != 'any')
            $query->where('lot_size', '<=', $maxsqft);

        if ($minacres !='' && $minacres !='any')
            $query->where('acre', '>=', $minacres);
        if ($maxacres != '' && $maxacres != 'any')
            $query->where('acre', '<=', $maxacres);

        if ($minstories !='' && $minstories !='any')
            $query->where('building_levels', '>=', $minstories);
        if ($maxstories != '' && $maxstories != 'any')
            $query->where('building_levels', '<=', $maxstories);

        if ($minyearbuilt !='' && $minyearbuilt !='any')
            $query->where('year_built', '>=', $minyearbuilt);
        if ($maxyearbuilt != '' && $maxyearbuilt != 'any')
            $query->where('year_built', '<=', $maxyearbuilt);

        if ($mingaragespace !='' && $mingaragespace !='any')
            $query->where('garage_spaces', '>=', $mingaragespace);
        if ($maxgaragespace != '' && $maxgaragespace != 'any')
            $query->where('garage_spaces', '<=', $maxgaragespace);

        if($dayson){
            $thestime = date("Y-m-d H:i:s");
            $date_from = date("Y-m-d H:i:s",strtotime("-".$dayson." days",strtotime($thestime)));
            $query->where('imported_at','>',$date_from);
        }

        if($pricereduce){
            $thestime = date("Y-m-d H:i:s");
            $date_from = date("Y-m-d H:i:s",strtotime("-".$pricereduce." days",strtotime($thestime)));
            #todo
//            $query->where('imported_at','>',$date_from);
        }

// all features integration
        foreach($features as $feature){
            switch($feature){
                case 'photo':
//                    Has Photos
                    $query->where('photos_count','>',0);
                    break;
                case 'OH':
//                    Open House
                    $query->where('open_house_flag','=',1);
                    break;
                case 'W':
//                    Waterfront
                    break;
                case 'NC':
//                    New Construction
                    break;
                case 'GR':
//                    Garage
                    $query->where('garage_spaces', '>', 0);
                    break;
                case 'P':
//                    Pool
                    $query->where('amenities', 'like', '%Pool%');
                    break;
                case 'F':
//                    Fireplace
                    $query->where('fireplace', '>', 0);
                    break;
                case 'MD':
//                    Master Downstairs
                    break;
                case 'HBASE':
//                    Basement
                    $query->where('basement_flag', '=', 'Y');
                    break;
                case 'HCPOOL':
//                    Community Pool
                    break;
                case 'HOA':
//                    Has HOA
                    break;
                case 'HP':
//                    Horse Property
                    break;
                case 'PUD':
//                    Planned Unit Development
                    break;
                case 'TC':
//                    Tennis Community
                    $query->where('amenities', 'like', '%tennis%');
                    break;
                case 'IRENT':
//                    Currently A Rental
                    break;
                case 'GAS':
//                    Gas Utilities
                    break;
                case 'HC':
//                    Handicap Equipped
                    $query->where('handicap_access', '!=', null);
                    break;
                case 'H':
//                    Historic Property
                    $query->where('type', 'like', '%Historic%');
                    break;
                case 'HMTIL':
//                    InLaw Suite
                    $query->where('rooms', 'like', '%In-Law%');
                    break;
                case 'GC':
//                    On Golf Course
                    $query->where('amenities', 'like', '%Golf Course%');
                    break;
                case 'IPW':
                    // Public Water
                    break;
                case 'ISP':
                    //Septic
                    $query->where('sewer', 'like', '%septic%');
                    break;
                case 'IS':
//                    Sewer
                    $query->where('sewer', '!=', null);
                    break;
                case 'UU':
//                    Underground Utilities
                    break;
                case 'IW':
//                    Well
                    break;
                case 'BRC':
//                    Brick Construction
                    $query->where('construction', 'like', '%Brick%');
                    break;
                case 'HCARP':
//                    Carport
                    break;
                case 'HD':
//                    Deck
                    $query->where('exterior', 'like', '%Deck%');
                    break;
                case 'ISFENCE':
//                    Fenced Yard
                    $query->where('exterior', 'like', '%Fenced Yard%');
                    break;
                case 'HAG':
//                    Garage - Attached
                    $query->where('garage_desc', 'like', '%Attached%');
                    break;
                case 'HDC':
//                    Garage - Detached
                    $query->where('garage_desc', 'like', '%Detached%');
                    break;
                case 'HHT':
//                    Hot Tub
                    $query->where('exterior', 'like', '%Hot Tub%');
                    break;
                case 'HOFSP':
//                    Parking - Off-Street

                    $query->where('exterior', 'like', '%Parking - Off-Street%');
                    break;
                case 'HPTO':
//                    Patio
                    $query->where('exterior', 'like', '%Patio%');
                    break;
                case 'HPAGP':
//                    Pool - Above Ground
                    $query->where('exterior', 'like', '%Pool - Above Ground%');
                    break;
                case 'HPIGP':
//                    Pool - Below Ground
                    $query->where('exterior', 'like', '%Pool - Below Ground%');

                    break;
                case 'HSS':
//                    Sprinkler System
                    $query->where('exterior', 'like', '%Sprinkler System%');
                    break;
                case 'HSB':
//                    Storage Buildings
                    $query->where('exterior', 'like', '%Storage%');
                    break;
                case 'HAC':
//                    Air Conditioning
                    $query->where('cooling', '!=', 'None');
                    break;
                case 'HBASE':
//                    Basement
                    $query->whereNotNull('basement_type');
                    break;
                case 'HFBASE':
//                    Basement - Finished
                    $query->where('basement_finish', 'like', 'Finished%');
                    break;
                case 'HPFB':
//                    Basement - Partially Finished
                    $query->where('basement_finish', 'like', '%Part Finished%');
                    break;
                case 'HUFBASE':
//                    Basement - Unfinished
                    $query->where('basement_finish', 'like', 'Unfinished%');
                    break;
                case 'HWOB':
//                    Basement - Walk-Out
                    $query->where('basement_access', '=', 'Walkout');
                    break;
                case 'BNROM':
//                    Bonus Room
                    break;
                case 'CPTFL':
//                    Carpet Floors
                    $query->where('finished_floor', 'like', '%Carpet%');
                    break;
                case 'HE':
//                    Elevator
                    $query->where('equipment', 'like', '%Elevator%');
                    break;
                case 'FRMD':
//                    Formal Dining
                    break;
                case 'GRM':
//                    Great Room
                    break;
                case 'HHF':
//                    Hardwood Floors
                    $query->where('finished_floor', 'like', '%Hardwood%');
                    break;
                case 'HEATE':
//                    Heat - Electric
                    $query->where('heat_system', 'like', '%Electric%');
                    break;
                case 'LAUND':
//                    Laundry Hookup
                    break;
                case 'HMFB':
//                    Main Floor Bedroom
                    break;
                case 'MD':
//                    Master Downstairs
                    break;
                case 'HNB':
//                    No Basement
                    $query->where('basement_type','=',null);
                    break;
                case 'TLF':
//                    Tile Floors
                    break;
                case 'HWIC':
//                    Walk-In Closet
                    break;
                case 'WD':
//                    Washer / Dryer In Unit
                    $query->whereRaw('equipment REGEXP Washer|Dryer');
                    break;
                case 'HWB':
//                    Wet Bar
                    $query->where('interior', 'like', '%Wet Bar%');
                    break;
                case 'CT':
//                    Contemporary
                    $query->where('type', 'like', '%Contemporary%');
                    break;
                case 'ILOLL':
//                    Log / Log Look
                    break;
                case 'LO':
//                    Lease Option
                    break;
                case 'IOWNF':
//                    Owner Financing
                    break;
            }
        }


        if($OfficeMLS)
            $query->whereIn('listing_office_id',$OfficeMLS);
        if(!empty($address)){
            if(!empty($street_no))
                $query->where('street_number', 'like', '%' . trim($street_no) . '%');

            if(!empty($street_name))
                $query->where('street_name', 'like', '%' . trim($street_name) . '%');
        }

        if(!empty($zip_code))
            $query->where('zip_code','=',$zip_code);
        if(!empty($beds) && ($beds != 'any'))
            $query->where('bedrooms','>',$beds);
        if(!empty($baths) && ($baths != 'any'))
            $query->where('total_baths','>',$baths);
        if(!empty($property_types)){
            foreach($property_types as $property_type){
                switch(strtolower($property_type)){
                    case 'sf':
                        $types[]='Single Family';
                        break;
                    case 'mf':
                        $types[]='Multi Family';
                        break;
                    case 'condo':
                        $types[]='condo';
                        break;
                    case 'land':
                        $types[]='land';
                        break;
                    case 'com':
                        $types[]='commercial';
                        break;
                    case 'rent':
                        $types[]='rental';
                        break;
                    default:
                        $types[]='Single Family';
                }
            }
//            $type_query="('%";
//            foreach($types as $key=>$val){
//                if($key){
//                    $type_query.="%', '%".$val;
//                }else
//                    $type_query.=$val;
//            }
//            $type_query.="%')";
            $type_query="'";
            foreach($types as $key=>$val){
                if($key){
                    $type_query.="|".$val;
                }else
                    $type_query.=$val;
            }
            $type_query.="'";

            if(!empty($types))
                $query->whereRaw('property_type REGEXP  '.$type_query);

        }    

        if(!empty($fav) && Auth::check()){
            $user_id=Auth::id();
            $fav_listings=SearchHistory::where('search_type','=','favorite')->where('user_id','=',$user_id)->distinct()->lists('search_name');
            
            if($limit == 0 ){
                $result=Listing::whereIn('listing_id',$fav_listings)->get();
            }else{
                $result=Listing::whereIn('listing_id',$fav_listings)->paginate($limit);    
            }
            
        }else{          
            if($limit == 0 ){
                $result = $query->paginate(20);
            }else{               

                if( $map_key =="map"){
                    $query1 = clone $query;
                    $result = $query1->select('id')->get();
                    
                    if(count($result) > 100 && $limit > 100) {
                        $result = $query->select('id', 'latitude', 'longitude')->paginate($limit);
                    } else {
                        $result = $query->paginate($limit);
                    }                    
                }else{
                    $result = $query->paginate($limit);
                }
                
            }
            
        }
        
        if (!$result->isEmpty()) {
            foreach($result as $key=>$property){
                $result[$key] = $this->_prepareData($property);
            }
            $result->success= true;
            return $result;
            
        } else {

            return Response::json(array(
                'error' => true,
                'message' => 'No Result Found'
                ),
            200
            );
        }
    }


    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function create()
    {
        //
    }


    /**
     * Store a newly created resource in storage.
     *
     * @return Response
     */
    public function store()
    {
        //
    }


    public function show($id)
    {

        $result = Listing::where('listing_id', $id)
        ->get();

        if (!$result->isEmpty()) {
            return $this->_prepareData($result->first());
        } else {
            return Response::json(array(
                'error' => true,
                'listing' => 'Mo Listing Found'),
            200
            );
        }
    }


    /**
     * Show the form for editing the specified resource.
     *
     * @param  int $id
     * @return Response
     */
    public function edit($id)
    {
        $result = Listing::where('listing_id', $id)
        ->get();

        if (!$result->isEmpty()) {
            return $result->first();
        } else {
            return Response::json(array(
                'error' => true,
                'listing' => 'Mo Listing Found'),
            200
            );
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  int $id
     * @return Response
     */
    public function update($id)
    {
        //
    }


    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    private function _prepareData($property)
    {
//        $property->favorite=true;
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
