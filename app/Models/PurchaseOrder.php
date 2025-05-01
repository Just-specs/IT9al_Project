<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    use HasFactory;

    protected $fillable = [
        'supplier_id',
        'total_amount',
        'status',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'purchase_order_id');
    }

    public function purchaseOrderReceivings()
    {
        return $this->hasMany(PurchaseOrderReceiving::class);
    }

    public function calculateTotalAmount()
    {
        return $this->orderDetails->sum(function ($detail) {
            return $detail->quantity * $detail->product->price_per_item;
        });
    }
}
