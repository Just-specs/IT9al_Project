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
        'specifications',
        'price_per_item',
        'status',
        'serial_number',
    ];

   
    public function updateStockStatus()
    {
        $newStatus = 'available';

        if ($this->quantity <= 0) {
            $newStatus = 'out of stock';
        } elseif ($this->quantity <= $this->min_stock_level) {
            $newStatus = 'low stock';
        }

        if ($this->status !== $newStatus) {
            $this->status = $newStatus;
            $this->save();
        }
    }

    // Define relationships
    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function inventoryIssues()
    {
        return $this->hasMany(InventoryIssue::class, 'product_id');
    }

    public function orderDetails()
    {
        return $this->hasMany(OrderDetail::class, 'product_id');
    }

    public function suppliers()
    {
        return $this->belongsToMany(Supplier::class, 'product_supplier');
    }

    public function inventoryLogs()
    {
        return $this->hasMany(InventoryLog::class);
    }

    public function isLowStock()
    {
        return $this->quantity <= $this->min_stock_level;
    }
}
