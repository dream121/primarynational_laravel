<?php

class UploadController extends AdminController {

    public function __construct(){
        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function postIndex($sub_dir=null)
    {
        //$name = $this->_randomString();
        //$ext = explode('.',$_FILES['file']['name']);
        //$filename = $name.'.'.$ext[1];
        $filename = $_FILES['file']['name'];
        $full_path=public_path().DS.'photos'.DS;
        if($sub_dir)
            $full_path.=$sub_dir.DS;
        if(!is_dir($full_path))
            mkdir($full_path);
        $destination = $full_path.$filename;
        $location =  $_FILES["file"]["tmp_name"];
        move_uploaded_file($location,$destination);
        if($sub_dir)
            echo url('photos/'.$sub_dir.'/'.$filename);
        else
            echo url('photos/'.$filename);
    }
    private function _randomString() {
        return md5(rand(100, 200));
    }
}
