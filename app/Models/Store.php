<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Store extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'location',
        'status',
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    public function storeItems()
    {
        return $this->hasMany(StoreItem::class);
    }
}
