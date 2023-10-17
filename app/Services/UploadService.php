<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class UploadService
{
    /**
     * Images upload path.
     */
    protected string $imagePath = '/app/public/uploads/images';

    /**
     * Files upload path.
     */
    protected string $filePath = '/app/public/uploads/files';

    /**
     * Upload an image file with Intervention Image.
     */
    public function image(UploadedFile $file, string $directory, string $old = null): string
    {
        // Prepare meta data
        $format = 'webp';
        $name = uniqid() . '.' . $format;
        $path = storage_path($this->imagePath) . '/' . $directory . '/' . $name;

        // Save new image
        Image::make($file)->encode($format)->save($path);

        // Remove old image
        $this->remove(storage_path($this->imagePath), $directory, $old);

        return $name;
    }

    /**
     * Upload a file with laravel storage class.
     */
    public function file(UploadedFile $file, string $directory, string $old = null): string
    {
        // Prepare meta data
        $format = $file->extension();
        $name = uniqid() . '.' . $format;
        $path = $this->filePath . '/' . $directory . '/' . $name;

        // Save new file
        /** @var Illuminate\Filesystem\FilesystemAdapter */
        $storage = Storage::disk('root');
        $storage->putFile($path, $file);

        // Remove old file
        $this->remove(storage_path($this->filePath), $directory, $old);

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
