<?php

class Blog extends Eloquent {

    protected $table = 'posts';

    protected $type = 'blog';

    protected $guarded = array();

    // its used in any insert/update operation
    protected $attributes = array(
        'type' => 'blog'
    );

    public function comments()
    {
    return $this->hasMany('Comment', 'post_id');
    }

    public function tags()
    {
        return $this->belongsToMany('Tag', 'post_tag', 'post_id', 'tag_id');
    }

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public function user()
    {
        return $this->belongsTo('User','author_id');
    }

    public static function rules($id=0)
    {
       return array(
           'title'=>'required',
           'slug'=>'required|unique:posts,slug,'.$id,
           'content'=>'required'
       );
    }
    
    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery();
        $query->where('type', '=', $this->type);
        return $query;
    }

    public static function getAll($limit = 10){
        return Blog::where('status','=','1')
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->simplePaginate($limit);
    }

    public static function getBlogBySlug($slug){
        return Blog::where('status','=','1')
            ->where('slug','=',$slug)
            ->with('user')
            ->with(array('comments'=>function($query){$query->where('comments.approved','=',1);},'comments.user.profile'))
            ->with('category')
            ->get()
            ->first();
    }

    public static function getRecent($exclude_item=null,$limit=4){
        if($exclude_item)
            return Blog::where('status','=','1')
                ->where('id','!=',$exclude_item)
                ->take($limit)
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->with('comments')
                ->get();

        return Blog::where('status','=','1')
            ->take($limit)
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->with('comments')
            ->get();
    }

    public static function getPopularBlog($exclude_item=null,$limit=4){
        if($exclude_item)
            return Blog::where('status','=','1')
                ->where('id','!=',$exclude_item)
                ->take($limit)
                ->orderBy('hit_count', 'desc')
                ->orderBy('created_at', 'desc')
                ->with('user')
                ->with('category')
                ->with('comments')
                ->get();
        return Blog::where('status','=','1')
            ->take($limit)
            ->orderBy('hit_count', 'desc')
            ->orderBy('created_at', 'desc')
            ->with('user')
            ->with('category')
            ->with('comments')
            ->get();
    }

    public static function getBlogByID($id){
        return Blog::where('id', $id)->first();
    }

    public static function getAllBlog($limit=10){
        return Blog::paginate($limit);
    }

    public static function getBlogByCategory($category_id,$exclude_item=null){
        if($exclude_item)
            return Blog::where('id','!=',$exclude_item)->where('category_id','=',$category_id)->with('category')->take(5)->get();

        return Blog::where('category_id','=',$category_id)->with('category')->take(5)->get();
    }
    public static function getBlogArchive(){
        return Blog::select(DB::raw("DISTINCT CONCAT(MONTHNAME(updated_at), ', ', YEAR(updated_at)) AS `month`"))->get();
    }
    public static function getBlogByMonth($month,$limit=10){
        $tmp=explode(', ',$month);
        $month=$tmp[0];
        $year=$tmp[1];
        return Blog::whereRaw("YEAR(updated_at) = '".$year."' AND MONTHNAME(updated_at) = '".$month."'")->paginate($limit);
    }

}
