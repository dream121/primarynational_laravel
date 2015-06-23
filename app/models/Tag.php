<?php

class Tag extends Eloquent {

    protected $guarded = array();

    protected $table = 'tags';
    
    public static $rules = array(
        'title'=>'required',
        'slug'=>'required'
    );
    
    public function blogs()
    {
        return $this->belongsToMany('Blog', 'post_tag', 'tag_id', 'post_id');
    }
    
    public function search($search_str)
    {
		return Tag::select('id','title as value','slug as label')->where('title', 'LIKE', '%' . $search_str . '%')->get();
	}

    public function getByTitle($name)
    {
        return Tag::where('title', '=',$name)->lists('id');
    }

    
    /*public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }*/
}
