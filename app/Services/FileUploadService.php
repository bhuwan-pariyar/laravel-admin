<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class FileUploadService
{
    public function uploadImage($image, $model = null, $imageCol="image", $modelName="user")
    {
        if (!is_file($image)) {
            return $image;
        }
        return $this->uploadByType($image, $model, $imageCol, $modelName);
    }

    private function uploadByType($image, $model, $imageCol, $modelName)
    {
        $this->removeImageIfExists($model, $imageCol);

        $now = Carbon::now();
        $hash = Str::random(40);

        $extension = $image->getExtension();
        $path = "uploads/$modelName/" . $now->year . "/" . $now->month;

        $file_path = $image->store($path, 'public');
        $file_path = str_replace('public/', '', $file_path);

        return $file_path;
        if (Storage::disk('public')->put($path, $image->__toString(), 'public')) {
            return $path;
        }
    }

    public function removeImageIfExists($model, $imageCol)
    {
        if ($model) {
            $file_path = $model->getAttributes()[$imageCol];
            if ($model->$imageCol != null && Storage::disk('public')->exists($file_path)) {
                Storage::disk('public')->delete($file_path);
            }
        }
    }

    public function uploadImageUrl($url, $model = null, $imageCol = 'image', $modelName = 'user')
    {
        if ($url) {
            $contents = file_get_contents($url);
            return $this->uploadByType($contents, $model, $imageCol, $modelName);
        }
        return null;
    }

    public function removeImageUsingPath($model, $imagePath)
    {
        if (Storage::disk('public')->exists($imagePath)) {
            return Storage::disk('public')->delete($imagePath);
        }
    }
}
