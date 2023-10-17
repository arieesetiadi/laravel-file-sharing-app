<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Intervention\Image\Facades\Image;

class FileService
{
    /**
     * Upload image path.
     */
    private string $imageUploadPath;

    /**
     * Upload file path.
     */
    private string $fileUploadPath;

    /**
     * Initiate class value
     */
    public function __construct()
    {
        $this->imageUploadPath = storage_path('app/public/uploads/images');
        $this->fileUploadPath = storage_path('app/public/uploads/files');
    }

    /**
     * Upload an image file with Intervention Image.
     */
    public function uploadImage(UploadedFile $file, string $directory, string $old = null): string
    {
        // Prepare meta data
        $format = 'webp';
        $name = uniqid() . '.' . $format;
        $path = $this->imageUploadPath . '/' . $directory . '/' . $name;

        // Save new image
        Image::make($file)->encode($format)->save($path, 90);

        // Remove old image
        $this->remove($this->imageUploadPath, $directory, $old);

        return $name;
    }

    /**
     * Remove file if exist.
     */
    public function remove(string $path, string $directory, string|null $name): void
    {
        if ($name) {
            $path = $path . '/' . $directory . '/' . $name;
            if (file_exists($path)) {
                File::delete($path);
            }
        }
    }
}
