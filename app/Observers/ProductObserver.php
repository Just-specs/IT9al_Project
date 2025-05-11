<?php

namespace App\Observers;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Services\AutoPurchaseOrderService;
use Illuminate\Support\Facades\Log;

class ProductObserver
{
    protected $autoPurchaseOrderService;
    
    public function __construct(AutoPurchaseOrderService $autoPurchaseOrderService)
    {
        $this->autoPurchaseOrderService = $autoPurchaseOrderService;
    }
    
    /**
     * Handle the Product "updated" event.
     */
    public function updated(Product $product): void
    {
        try {
            // Check if quantity was updated and is now below or equal to min_stock_level
            if ($product->wasChanged('quantity') && $product->quantity <= $product->min_stock_level) {
                // Check if the product has any suppliers
                if ($product->suppliers->isEmpty()) {
                    Log::info("Product ID {$product->id} is low on stock but has no suppliers assigned.");
                    return;
                }

                // Check if we already have a pending PO for this product with this supplier
                $supplierId = $product->suppliers->first()->id;
                $existingdraftPO = PurchaseOrder::where('status', 'draft')
                    ->where('supplier_id', $supplierId)
                    ->whereHas('orderDetails', function($query) use ($product) {
                        $query->where('product_id', $product->id);
                    })
                    ->exists();

                if (!$existingdraftPO) {
                    // Generate draft PO
                    $createdPOs = $this->autoPurchaseOrderService->generateDraftPurchaseOrders();
                    Log::info("Auto-generated purchase orders for low stock product ID {$product->id}. Created PO IDs: " . implode(', ', $createdPOs));
                } else {
                    Log::info("Product ID {$product->id} is low on stock but already has a pending PO.");
                }
            }
        } catch (\Exception $e) {
            Log::error("Error in ProductObserver: " . $e->getMessage());
        }
    }
}