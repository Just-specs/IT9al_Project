<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'type',
        'quantity',
        'min_stock_level',
        'supplier_id',
        'serial_number',
        'specifications',
        'status',
    ];

    // Define relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inventoryIssues()
    {
        return $this->hasMany(InventoryIssue::class, 'part_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'part_id');
    }

    // Check if product is low on stock
    public function isLowStock()
    {
        return $this->quantity <= $this->min_stock_level;
    }
}
