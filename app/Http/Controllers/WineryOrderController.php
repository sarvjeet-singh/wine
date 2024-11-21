<?php

namespace App\Http\Controllers;

use App\Models\WineryOrder;
use Illuminate\Http\Request;

class WineryOrderController extends Controller
{
    public function index() {}

    public function vendorOrders($vendorid)
    {
        $orders = WineryOrder::where('vendor_buyer_id', $vendorid)
            ->orderBy('created_at', 'desc')
            ->get();
        return view('VendorDashboard.winery-orders.vendor-orders', compact('orders', 'vendorid'));
    }

    public function vendorOrderDetail($orderid, $vendorid)
    {
        $order = WineryOrder::where('id', $orderid)->first();
        return view('VendorDashboard.winery-orders.vendor-order-detail', compact('order', 'vendorid'));
    }

    public function shopOrders($vendorid)
    {
        $orders = WineryOrder::where('vendor_seller_id', $vendorid)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('VendorDashboard.winery-orders.shop-orders', compact('orders', 'vendorid'));
    }

    public function shopOrderDetail($orderid, $vendorid)
    {
        $order = WineryOrder::where('id', $orderid)->first();
        return view('VendorDashboard.winery-orders.shop-order-detail', compact('order', 'vendorid'));
    }

    public function shopOrderUpdateStatus(Request $request, $orderid, $vendorid)
    {
        $order = WineryOrder::findOrFail($orderid);

        // Validate the new status value
        $request->validate([
            'status' => 'required|string|max:255'
        ]);

        // Update the status
        $order->status = $request->input('status');
        $order->save();

        return response()->json([
            'success' => true,
            'message' => 'Delivery status updated successfully!',
            'status' => $order->status,
        ]);
    }
}
