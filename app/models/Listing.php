<?php

class Listing extends Eloquent {

    protected $guarded = array();

    protected $table = 'properties';

    public static function popularListing(){

        return Listing::where('status', 'like', '%' . 'active' . '%')->where('hit_count','>=','5')->orderBy('hit_count','DESC')->take(3)->get();

    }
}
