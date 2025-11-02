<?php

namespace App\Lib;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class FileManagement
{
    protected $allowedExtensions = ['jpg', 'jpeg', 'png', 'webp', 'svg', 'gif'];

    public function uploadImage(UploadedFile $file, string $subFolder = '', ?string $filename = null): ?string
    {
        $basePath = dirname(__DIR__, 3) . '/assets/images';
        $fullPath = $basePath . ($subFolder ? '/' . $subFolder : '');

        // Create directory if it doesn't exist
        if (!File::exists($fullPath)) {
            File::makeDirectory($fullPath, 0777, true);
        }

        $extension = strtolower($file->getClientOriginalExtension());
        if (!in_array($extension, $this->allowedExtensions)) {
            return null;
        }

        if ($file->isValid()) {
            $filename = $filename ?: uniqid() . '.' . $extension;
            if ($file->move($fullPath, $filename)) {
                return 'assets/images/' . ($subFolder ? $subFolder . '/' : '') . $filename;
            }
        }

        return null;
    }

    public function delete(string $filePath): bool
    {
        $fullPath = dirname(__DIR__, 3) . '/' . $filePath;
        return File::exists($fullPath) ? File::delete($fullPath) : false;
    }
}
