<?php

namespace App\Repositories\Item;

use App\Services\FileUploadService;

class ItemRepository implements ItemRepositoryInterface
{
    protected $fileUploadService;
    public function __construct(FileUploadService $fileUploadService)
    {
        $this->fileUploadService = $fileUploadService;
    }
}
