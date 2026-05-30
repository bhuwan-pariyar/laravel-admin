<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transfer extends Model
{
    protected $fillable = [
        'from_store_id',
        'to_store_id',
        'transfer_no',
        'transfer_date',
        'status',
        'remarks',
        'created_by',
    ];

    protected $casts = [
        'transfer_date' => 'date',
    ];

    public function fromStore()
    {
        return $this->belongsTo(Store::class, 'from_store_id');
    }

    public function toStore()
    {
        return $this->belongsTo(Store::class, 'to_store_id');
    }

    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function items()
    {
        return $this->hasMany(TransferItem::class);
    }
}
