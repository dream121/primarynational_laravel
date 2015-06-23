<?php
/**
 * Created by JetBrains PhpStorm.
 * User: siddik
 * Date: 6/7/14
 * Time: 2:21 PM
 * To change this template use File | Settings | File Templates.
 */
class Util
{
    /// ***********
    // This is useful when we sent status value Active or Inactive instead of int value 0 or 1
    // e.g: select * from table where table.status = Util::ACTIVE;
    /// ********************
   const ACTIVE = 1;
   const IN_ACTIVE = 0;

    // Start Table Name
    const TABLE_CATEGORY = "categories";
    const TABLE_POST = "posts";
    const RESOURCE_IMAGE_PATH ='/photos/resources';



    // End Table Name

    /// ***********
    // param: $val = 1, 0; Render Status value from UI or any Model or Controller.
    // From Controler or View: %status = Util::getStatus($statusVal)
    /// ********************
    public static function getStatus($val) {
       $status = "Inactive";
        if($val)
            $status = "Active";
        return $status;
    }


}
