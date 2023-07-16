<?php

namespace App\Traits;

use App\Models\Image;

trait ImageTrait
{
    public function createImage($filename,$class_object){
        $img = new Image();
        $img->filename = $filename;
        $img->imageable_type = get_class($class_object);
        $img->imageable_id = $class_object->id;
        $img->save();
    }
}