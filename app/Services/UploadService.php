<?php

namespace App\Services;

use Carbon\Carbon;
use Illuminate\Support\Facades\Storage;
use Livewire\Features\SupportFileUploads\TemporaryUploadedFile;

class UploadService
{
    public function uploadImage($image, $model = null, $imageCol = 'image', $modelName = 'users')
    {
        if (!($image instanceof TemporaryUploadedFile)) {
            return $image;
        }

        $this->removeImageIfExists($model, $imageCol);

        $now = Carbon::now();
        $path = "uploads/{$modelName}/{$now->year}/{$now->month}";

        return $image->store($path, 'public');
    }

    public function removeImageIfExists($model, $imageCol)
    {
        if ($model && $model->$imageCol && Storage::disk('public')->exists($model->$imageCol)) {
            Storage::disk('public')->delete($model->$imageCol);
        }
    }
}
