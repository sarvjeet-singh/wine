<?php

namespace App\Http\Controllers;

use App\Repositories\WineryCartRepository;
use Illuminate\Http\Request;
use App\Models\VendorWine;
use App\Models\Vendor;
use Auth;

class WineryCartController extends Controller
{
    protected $cartRepository;

    public function __construct(WineryCartRepository $cartRepository)
    {
        $this->cartRepository = $cartRepository;
    }

    public function index($shopid = null, $vendorid)
    {
        $vendor = Vendor::where('id', $shopid)
            ->first();
        $cart = null;
        if ($shopid) {
            $cart = $this->cartRepository->getCart(Auth::id(), $shopid, $vendorid);
        }
        return view('VendorDashboard.winery.cart', compact('cart', 'vendorid', 'vendor'));
    }

    public function add(Request $request, $shopid, $vendorid)
    {
        // Get the current user's cart
        $cart = $this->cartRepository->getCart(Auth::id(), $shopid, $vendorid);

        // Get the wine details from the vendor's inventory
        $wine = VendorWine::where('vendor_id', $shopid)
            ->where('id', $request->id)
            ->first();

        if (!$wine) {
            return response()->json(
                [
                    'message' => 'Wine item not found in inventory.',
                    'status' => 'error'
                ],
                404
            );
        }

        // Get the quantity of the same wine already in the cart
        $cartWineQuantity = $this->cartRepository->getItemQuantityInCart($cart, $request->id);

        // Calculate the total quantity in the cart after adding the requested quantity
        $totalQuantityInCart = $cartWineQuantity + $request->quantity;

        // Check if requested quantity exceeds available inventory
        if ($totalQuantityInCart > $wine->inventory) {
            return response()->json(
                [
                    'message' => 'Requested quantity exceeds available stock.',
                    'status' => 'error',
                    'available_quantity' => $wine->inventory
                ],
                400
            );
        }

        // Add item to cart if inventory is sufficient
        $this->cartRepository->addItem($cart, $request->id, $request->quantity, $vendorid);

        // Get updated cart item count
        $cartItemCount = $this->cartRepository->getItemCount($cart);

        return response()->json(
            [
                'message' => 'Item added to cart!',
                'status' => 'success',
                'cartItemCount' => $cartItemCount
            ]
        );
    }

    public function remove($productId, $shopid, $vendorid)
    {
        $cart = $this->cartRepository->getCart(Auth::id(), $shopid, $vendorid);
        $this->cartRepository->removeItem($cart, $productId, $vendorid);

        return response()->json(['message' => 'Item removed from cart!', 'status' => 'success']);
    }

    public function update(Request $request, $productId, $shopid, $vendorid)
    {
        $cart = $this->cartRepository->getCart(Auth::id(), $shopid, $vendorid);
        // Get the quantity of the same wine already in the cart
        $cartWineQuantity = $this->cartRepository->getItemQuantityInCart($cart, $request->id);

        // Calculate the total quantity in the cart after adding the requested quantity
        $totalQuantityInCart = $cartWineQuantity + $request->quantity;

        $wine = VendorWine::where('vendor_id', $shopid)
            ->where('id', $productId)
            ->first();

        if (!$wine) {
            return response()->json(
                [
                    'message' => 'Wine item not found in inventory.',
                    'status' => 'error'
                ],
                404
            );
        }

        // Check if requested quantity exceeds available inventory
        if ($totalQuantityInCart > $wine->inventory) {
            return response()->json(
                [
                    'message' => 'Requested quantity exceeds available stock.',
                    'status' => 'error',
                    'available_quantity' => $wine->inventory
                ],
                400
            );
        }
        $this->cartRepository->updateItemQuantity($cart, $productId, $request->quantity, $vendorid);

        return response()->json(['message' => 'Cart updated!', 'status' => 'success']);
    }
}
