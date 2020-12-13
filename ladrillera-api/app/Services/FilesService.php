<?php

namespace App\Services;


use App\Traits\UploadTrait;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class FilesService
{
    public const CLIENTS_DIR = "clients";
    public const EMPLOYEES_DIR = "employees";

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

    public function getFilesFromDirectory($disk, $directory)
    {
        $files = Storage::disk($disk)->files($directory);
        Log::info('Getting files from ' . $disk . " disk " . " and directory " . $directory);

        return $files;
    }

    public function getFileFromDirectory($disk, $filename)
    {
        $file = Storage::disk($disk)->get($filename);
        Log::info('Getting file from ' . $disk . " disk " . " and filename " . $filename);

        return $file;
    }

    public function getFilesFromClientsDirectory($directory)
    {
        $files = $this->getFilesFromDirectory($this::CLIENTS_DIR, $directory);
        Log::info('Getting files from clients' . " disk " . " and directory " . $directory);

        return $files;
    }

    public function getFileFromClientsDirectory($filename)
    {
        $file = $this->getFileFromDirectory($this::CLIENTS_DIR, $filename);
        Log::info('Getting files from clients' . " disk " . " and path " . $filename);

        return $file;
    }

    public function hasClientDirectory($cc_nit)
    {
        return Storage::disk($this::CLIENTS_DIR)->exists($cc_nit);
    }
}
