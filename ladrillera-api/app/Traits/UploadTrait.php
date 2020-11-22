<?php

/**
 * Gist https://gist.github.com/mabuak/6bd06a49e4b98ea63b781ecdbd711f40
 * 
 */

namespace App\Traits;

use Illuminate\Support\Str;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

trait UploadTrait
{

    /**
     * @return bool
     */
    private function createUploadFolder($diskRootDir, $uploadPath): bool
    {
        if (!file_exists(config($diskRootDir) . '/' . $uploadPath)) {
            $attachmentPath = config($diskRootDir) . '/' . $uploadPath;
            mkdir($attachmentPath, 0777);

            // Storage::put('public/' . $uploadPath . '/' . $folderName . '/index.html', 'Silent Is Golden');

            return true;
        }

        return false;
    }

    public function uploadOne(UploadedFile $uploaded_file, $folder = null, $filename = null, $disk = 'public')
    {
        $name = !is_null($filename) ? $filename : Str::random(25);

        $filePath = $uploaded_file->storeAs($folder, $name . '.' . $uploaded_file->getClientOriginalExtension(), $disk);

        Log::info('File ' . $name . " to " . $folder . "=>" . $filePath);
        return $filePath;
    }
}
