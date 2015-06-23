<?php

class CategoryController extends AdminController
{

    public function getIndex($type=null)
    {
        if($type)
            $categories = Category::getCategoryByType($type);
       else
           $categories = Category::getAllCategory('resource');
        return View::make('admin.category.index')->with('categories',$categories);
    }

    public function postCreate(){

        $id = 0;
        $inputData = Input::all();
        $validator = Validator::make($inputData, Category::rules(0));
        $type = Input::get('type');

        $data = array();
        if ($validator->passes()) {
            $category = new Category();
            $category->insertCategory($inputData,$type);
            $id = $category->id;
            $data['success'] = true;
            $data['id']= $id;
        }else{
            $data['success'] = false;
            $data['errors'] = $validator->getMessageBag()->toArray();
            $data['id']= $id;
        }
        return Response::json( $data );
    }

    public function getCreate(){
       return View::make('admin.category.create');
    }

    public function getEdit($id)
    {
        $category = Category::find($id);
        return View::make('admin.category.edit')->with(compact('category'));
    }

    public function postEdit($id){

        $inputData = Input::all();
        $validator = Validator::make($inputData, Category::rules($id));
        $data = array();
        if ($validator->passes()) {
            $category = new Category();
            $category->updateCategory($id,$inputData);
            $data['success'] = true;

        }else{
            $data['errors'] = $validator->getMessageBag()->toArray();
            $data['success'] = false;
        }
        return Response::json( $data );
    }

    public function getDelete($id){

        $category = Category::deleteResourceTypeCategory($id);

        if($category){
            $data['success'] = true;
            $data['message']  = 'Successfully deleted this item';
        }else{
            $data['success'] = false;
            $data['message']  = 'Delete operation failed.';
        }

        return Response::json( $data );
    }

}
