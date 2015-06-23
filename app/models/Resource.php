<?php

class Resource extends Eloquent
{
    protected $guarded = array();

    protected $table = 'posts';

    protected static $post_type = 'resource';

    public function category()
    {
        return $this->belongsTo('Category');
    }

    public static function rules($id=0){
        return array(
            'title'=>'required',
            'content'=>'required',
            'slug'=>'required|unique:posts,slug,'.$id
        );
    }



    public function insertResource($data)
    {
        $this->title = $data['title'];
        $this->type = self::$post_type;
        $this->slug = $data['slug'];
        $this->content = $data['content'];
        $this->author_id = Auth::id();
        $this->status = $data['status'];
        $this->category_id = $data['category_id'];
        $this->comment_count = 0;
        $result = $this->save();
        return $result;
    }

    public function updateResource($id,$data)
    {
        $resource = $this::find($id);
        $resource->title = $data['title'];
        $resource->slug = $data['slug'];
        $resource->content = $data['content'];
        $resource->status = $data['status'];
        $resource->category_id = $data['category_id'];
        $resource->updated_at=date('Y-m-d H:i:s');

        $resource->save();
    }

    public static function getResourceByID($id){
        return Resource::where('id', $id)->where('type', self::$post_type)->first();
    }

    public static function getAllResources(){
        return Resource::where('type', self::$post_type )->paginate(10);
    }

    public static function getResourcesByCategory($category_id){
        return Resource::where('category_id',$category_id)->get();
    }



}
