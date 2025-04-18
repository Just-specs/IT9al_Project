<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderDetail extends Model
{
    use HasFactory;

    protected $fillable = [
        'part_id',
        'purchase_order_id',
        'quantity_ordered',
        'order_date'
    ];

    public function product()
    {
        return $this->belongsTo(Product::class, 'part_id');
    }

    public function purchaseOrder()
    {
        return $this->belongsTo(PurchaseOrder::class);
    }
}