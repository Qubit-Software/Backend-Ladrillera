<?php

namespace App\Http\Services;


use App\Traits\UploadTrait;



class FilesService{

    use UploadTrait;




    public function saveFile($file, $filePath, $disk){
        // Upload image
        $this->uploadOne($file, $folder, $name, $disk);
        // Set user profile image path in database to filePath
        return true;
    }
}

?>