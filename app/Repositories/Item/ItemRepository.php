<?php

namespace App\Repositories\Item;

use App\Models\Item;

class ItemRepository implements ItemRepositoryInterface
{
    public function all()
    {
        return Item::all();
    }

    public function find(int $id): ?Item
    {
        return Item::findOrFail($id);
    }

    public function create(array $data): Item
    {
        return Item::create($data);
    }

    public function update(int $id, array $data): Item
    {
        $item = Item::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete(int $id): bool
    {
        $item = Item::findOrFail($id);
        return $item->delete();
    }
}
