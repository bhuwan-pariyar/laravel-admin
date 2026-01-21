<?php

namespace App\Repositories\Item;

use App\Models\Item;

interface ItemRepositoryInterface
{
    public function all();
    public function find(int $id): ?Item;
    public function create(array $data): Item;
    public function update(int $id, array $data): Item;
    public function delete(int $id): bool;
}
