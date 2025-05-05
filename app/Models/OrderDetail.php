<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'purchase_order_id',
        'quantity_ordered',
        'order_date',
    ];

    protected $casts = [
        'order_date' => 'datetime',
    ];

    /**
     * Get the computer part associated with this order detail.
     */
    public function product(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'part_id');
    }

    /**
     * Get the purchase order associated with this order detail.
     */
    public function purchaseOrder(): BelongsTo
    {
        return $this->belongsTo(PurchaseOrder::class);
    }

    /**
     * Get the receiving records associated with this order detail.
     */
    public function receivings(): HasMany
    {
        return $this->hasMany(PurchaseOrderReceiving::class);
    }
}