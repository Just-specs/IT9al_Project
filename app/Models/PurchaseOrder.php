<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'total_amount',
        'status',
    ];
    
    /**
     * Get the supplier associated with this purchase order.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'order_details', 'purchase_order_id', 'product_id')
            ->withPivot('quantity_ordered', 'price_per_item')
            ->select(['products.*', 'order_details.quantity_ordered', 'order_details.price_per_item']);
    }

    public function orderDetails(): HasMany
    {
        return $this->hasMany(OrderDetail::class);
    }

    /**
     * Get the purchase order receiving records associated with this purchase order.
     */
    public function receivings(): HasMany
    {
        return $this->hasMany(PurchaseOrderReceiving::class, 'order_detail_id');
    }
    
    /**
     * Scope a query to only include draft purchase orders.
     */
    public function scopeDraft($query)
    {
        return $query->where('status', 'draft');
    }
}