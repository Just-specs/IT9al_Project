<?php

namespace App\Http\Controllers;

use App\Services\AutoPurchaseOrderService;
use Illuminate\Http\Request;

class AutoPurchaseOrderController extends Controller
{
    protected $autoPurchaseOrderService;
    
    public function __construct(AutoPurchaseOrderService $autoPurchaseOrderService)
    {
        $this->autoPurchaseOrderService = $autoPurchaseOrderService;
    }
    
    /**
     * Generate draft purchase orders for low stock items
     */
    public function generateDrafts()
    {
        $createdPurchaseOrders = $this->autoPurchaseOrderService->generateDraftPurchaseOrders();
        
        if (count($createdPurchaseOrders) > 0) {
            return redirect()->route('purchase-orders.index')
                ->with('success', count($createdPurchaseOrders) . ' draft purchase order(s) created for low stock items.');
        }
        
        return redirect()->route('purchase-orders.index')
            ->with('info', 'No draft purchase orders were created. Either no items are below minimum stock level or they have no assigned suppliers.');
    }
}