<?php

namespace App\Services;


use App\Traits\UploadTrait;


class FilesService{

    use UploadTrait;

    /**
     * Instantiate a new FilesService instance.
     */
    public function __construct()
    {

    }

    public function saveClientFile($file, $name, $folder){
        // Upload image
        $this->uploadOne($file, $folder, $name, "clients");
        // Set user profile image path in database to filePath
        return true;
    }

    public function saveEmployeeFile($file, $name, $folder){
        // Upload image
        $this->uploadOne($file, $folder, $name, "employees");
        // Set user profile image path in database to filePath
        return true;
    }

    public function saveFile($file, $folder, $name,  $disk){
        // Upload image
        $this->uploadOne($file, $folder, $name, $disk);
        // Set user profile image path in database to filePath
        return true;
    }
}
