<?php

namespace App\Services;


use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Log;

class FilesService
{

    use UploadTrait;

    /**
     * Instantiate a new FilesService instance.
     */
    public function __construct()
    {
    }

    public function saveClientFile($file, $name, $folder)
    {
        return $this->saveFile($file, $folder, $name, "clients");
    }

    public function saveEmployeeFile($file, $name, $folder)
    {
        // Upload image
        return $this->saveFile($file, $folder, $name, "employees");
    }

    public function saveFile($file, $folder, $name,  $disk)
    {
        // Upload image
        $new_filePath = $this->uploadOne($file, $folder, $name, $disk);
        // Set user profile image path in database to filePath
        Log::info('File ' . $name . " to " . $folder . "=> The file " . $file);
        return $new_filePath;
    }
}
