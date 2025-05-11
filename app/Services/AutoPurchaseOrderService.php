<?php

namespace App\Services;

use App\Models\Product;
use App\Models\PurchaseOrder;
use App\Models\OrderDetail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class AutoPurchaseOrderService
{
    /**
     * Generate draft purchase orders for all products below minimum stock level
     * 
     * @return array Array of created purchase order IDs
     */
    public function generateDraftPurchaseOrders()
    {
        // Get products that are below minimum stock level
        $lowStockProducts = Product::whereRaw('quantity <= min_stock_level')
            ->with('suppliers')
            ->get();
        
        if ($lowStockProducts->isEmpty()) {
            Log::info("No products below minimum stock level found.");
            return [];
        }
        
        Log::info("Found " . $lowStockProducts->count() . " products below minimum stock level");
        
        // Group products by supplier to create one PO per supplier
        $productsBySupplier = [];
        foreach ($lowStockProducts as $product) {
            if ($product->suppliers->isEmpty()) {
                Log::info("Product ID {$product->id} ({$product->name}) has no suppliers assigned - skipping");
                continue; // Skip products with no suppliers
            }
            
            // Use the first supplier for simplicity
            $supplierId = $product->suppliers->first()->id;
            
            // Check if we already have a draft PO for this product with this supplier
            $existingDraftPO = PurchaseOrder::draft()
                ->where('supplier_id', $supplierId)
                ->whereHas('orderDetails', function($query) use ($product) {
                    $query->where('part_id', $product->id);
                })
                ->exists();
                
            if ($existingDraftPO) {
                Log::info("Product ID {$product->id} ({$product->name}) already has a draft PO - skipping");
                continue; // Skip if there's already a draft PO
            }
            
            if (!isset($productsBySupplier[$supplierId])) {
                $productsBySupplier[$supplierId] = [];
            }
            
            $productsBySupplier[$supplierId][] = $product;
        }
        
        if (empty($productsBySupplier)) {
            Log::info("No products to create purchase orders for (either all have suppliers or already have draft POs)");
            return [];
        }
        
        $createdPurchaseOrders = [];
        
        // Create a purchase order for each supplier
        foreach ($productsBySupplier as $supplierId => $products) {
            try {
                DB::beginTransaction();
                
                // Calculate total amount
                $totalAmount = 0;
                foreach ($products as $product) {
                    // Calculate quantity to order (difference between min_stock_level and current quantity, plus a buffer)
                    $orderQuantity = ($product->min_stock_level - $product->quantity) + 5;
                    $totalAmount += $orderQuantity * $product->price_per_item;
                }
                
                // Create purchase order
                $purchaseOrder = PurchaseOrder::create([
                    'supplier_id' => $supplierId,
                    'total_amount' => $totalAmount,
                    'status' => 'draft', // This is a draft PO
                ]);
                
                Log::info("Created draft PO ID {$purchaseOrder->id} for supplier ID {$supplierId}");
                
                // Create order details
                foreach ($products as $product) {
                    $orderQuantity = ($product->min_stock_level - $product->quantity) + 5;
                    
                    OrderDetail::create([
                        'part_id' => $product->id,
                        'purchase_order_id' => $purchaseOrder->id,
                        'quantity_ordered' => $orderQuantity,
                        'price_per_item' => $product->price_per_item,
                        'order_date' => now(),
                    ]);
                    
                    Log::info("Added product ID {$product->id} ({$product->name}) to PO ID {$purchaseOrder->id}, quantity: {$orderQuantity}");
                }
                
                $createdPurchaseOrders[] = $purchaseOrder->id;
                
                DB::commit();
            } catch (\Exception $e) {
                DB::rollBack();
                Log::error('Failed to create auto purchase order: ' . $e->getMessage());
            }
        }
        
        Log::info("Created " . count($createdPurchaseOrders) . " draft purchase orders");
        
        return $createdPurchaseOrders;
    }
}