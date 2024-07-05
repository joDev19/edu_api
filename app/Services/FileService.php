<?php

namespace App\Services;
use Illuminate\Http\UploadedFile;
class FileService
{
    public function storeFile(UploadedFile $file, $folder="enoncers")
    {
        return $file->storeAs($folder, uniqid('_', true).'.pdf');
    }
}
