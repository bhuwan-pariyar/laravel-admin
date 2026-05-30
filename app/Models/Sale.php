<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Sale extends Model
{
    protected $fillable = [
        'customer_id',
        'store_id',
        'invoice_no',
        'sale_date',
        'tax_amount',
        'discount_amount',
        'grand_total',
        'payment_status',
        'remarks',
    ];

    protected $casts = [
        'sale_date' => 'date',
        'tax_amount' => 'decimal:2',
        'discount_amount' => 'decimal:2',
        'grand_total' => 'decimal:2',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function items()
    {
        return $this->hasMany(SaleItem::class);
    }
}
