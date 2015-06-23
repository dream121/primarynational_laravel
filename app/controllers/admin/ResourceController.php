<?php

class ResourceController extends AdminController
{

    public function __construct(){
        View::share('page_title', 'Manage Resource');
    }

    public function getIndex()
    {
        $resources = Resource::getAllResources();
        return View::make('admin.resources.index')->with('resources',$resources);
    }

    public function getShow($id)
    {
        $resource = Resource::getResourceByID($id);
        if($resource==null){
            return Redirect::to('admin/resource/index')
                ->with('error_msg', 'No record found.');
        }
        return View::make('admin.resources.show')->with(compact('resource'));
    }

    public function getCreate()
    {
        $categories = Category::where('type','=','resource')->lists('name', 'id');
        return View::make('admin.resources.create')->with(compact('categories'));
    }

    public function postCreate()
    {
        // Need to set upload folder directory in config.php for uploading images from editor.
        // Path to config.php = public/assets/js/plugin/tinymce/plugins/jbimages/config.php
        $inputData = Input::all();
        $validator = Validator::make($inputData, Resource::rules(0));

        if ($validator->passes()) {
            $resource = new Resource();
            $resource->insertResource($inputData);
            return Redirect::to('admin/resource/index')
                ->with('success_msg', 'Resource created successfully');
        }else{
           return Redirect::to('admin/resource/create')
                ->with('error_msg', 'Your data could not be saved!! Something wrong!!')
                ->withErrors($validator)
                ->withInput();
        }
    }

    public function getEdit($id)
    {
        $resource = Resource::getResourceByID($id);
        $categories = Category::where('type','=','resource')->lists('name', 'id');
        if($resource==null){
            return Redirect::to('admin/resource/index')
                ->with('error_msg', 'No record found.');
        }
        return View::make('admin.resources.edit')->with(compact('resource','categories'));
    }

    public function postEdit($id)
    {
        // Need to set upload folder directory in config.php for uploading images from editor.
        // Path to config.php = public/assets/js/plugin/tinymce/plugins/jbimages/config.php

        $resource  = Resource::getResourceByID($id);
        if($resource==null){
            return Redirect::back()
                ->with('error_msg', 'Record not found!!')
                ->withInput();
        }

        $inputData = Input::all();

        $validator = Validator::make($inputData, Resource::rules($id));
        //$destinationPath = public_path().'/photos/';
        if ($validator->passes()) {
            $new_resource = new Resource();
            $new_resource->updateResource($id,$inputData);
           return Redirect::to('admin/resource/index')
                ->with('success_msg', 'Resource updated successfully');
        }else{
            return Redirect::back()
                ->with('error_msg', 'Your data could not be updated!! Something wrong!!')
                ->withErrors($validator)
                ->withInput();
        }

    }

    public function getActivate($id,$status='no')
    {
        $resource = Resource::find($id);
        $resource->status   =($status==='yes')?1:0;
        $resource->save();

        return Redirect::back()
            ->with('success_msg', 'Resource Updated successfully');
    }

    public function getDelete($id)
    {
        // delete
        $resource = Resource::find($id);
        if($resource!=null)
            $resource->delete();

        return Redirect::to('admin/resource/index')
            ->with('success_msg', 'Resource deleted successfully');
    }

    public function store()
    {
        //
    }
}
