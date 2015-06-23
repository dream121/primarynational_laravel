<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siddik
 * Date: 6/7/14
 * Time: 1:38 PM
 * To change this template use File | Settings | File Templates.
 */
class Category extends Eloquent
{
    protected $guarded = array();

    protected $table = 'categories';

    protected static $category_resource = 'resource';

    public function resources()
    {
        return $this->hasMany('Resource');
    }

    public static function rules($id=0)
    {
        return array(
            'name'=>'required',
            'slug'=>'required|unique:categories,slug,'.$id
        );
    }

    public static function getAllCategory(){
        return Category::get();
    }
    public static function getCategoryByType($type){
        return Category::where('type', '=', $type)->get();
    }

    public function insertCategory($data,$category_type)
    {
        $this->name = $data['name'];
        $this->type = $category_type;
        $this->slug = $data['slug'];
        $this->status = isset($data['status'])?1:0;
        $result = $this->save();
        return $result;
    }

    public function updateCategory($id,$data)
    {
        $category = $this::find($id);
        $category->name = $data['name'];
        $category->slug = $data['slug'];
        $category->type = $data['type'];
        $category->status = isset($data['status'])?1:0;
        $category->updated_at=date('Y-m-d H:i:s');
        $category->save();
    }

    public static function deleteResourceTypeCategory($id){

        $category = Category::where('id',$id)->where('type',self::$category_resource);
        $result = $category->delete();

        if($result){
            $resources = Resource::getResourcesByCategory($id);
            if(count($resources)>0) {
                foreach($resources as $resource){
                    $resource->category_id=0;
                    $resource->save();
                }
                $result = true;
            }
        }

       return $result;
    }

}
