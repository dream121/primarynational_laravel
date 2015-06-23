<?php

class Banner extends Eloquent {

    protected $guarded = array();

    protected $table = 'posts';
    protected $type = 'banner';
    protected $attributes = array(
        'type' => 'banner'
    );

    public static function rules($id=0)
    {
        return array(
            'title'=>'required',
            'link'=>'url',
            'image_file' => 'sometimes|required|mimes:jpeg,gif,png|image|image_size:*',
            'image_file_next' => 'mimes:jpeg,gif,png|image|image_size:*'
        );
    }

    public function user()
    {
        return $this->belongsTo('User','author_id');
    }

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }

    public static function getBanners(){

        return Banner::where('status','=','1')
            ->orderBy('created_at', 'desc')
            ->get();
    }
}
