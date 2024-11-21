<?php

namespace App\Repositories;

use App\Models\WineryCart;
use App\Models\WineryCartItem;

class WineryCartRepository
{
    public function getCart($userId, $shopid = null, $vendorid = null)
    {
        if (!$shopid) {
            return WineryCart::where('user_id', $userId)->where('status', 'active')->first([
                'user_id' => $userId,
                'status' => 'active',
                'vendor_id' => $vendorid
            ]);
        }
        return WineryCart::where('user_id', $userId)->where('status', 'active')->firstOrCreate([
            'user_id' => $userId,
            'status' => 'active',
            'shop_id' => $shopid,
            'vendor_id' => $vendorid
        ]);
    }

    public function addItem($cart, $vendor_wine_id, $quantity = 1, $shopid, $vendorid = null)
    {
        $cartItem = $cart->items()->where('vendor_wine_id', $vendor_wine_id)->first();
        if ($cartItem) {
            $cartItem->quantity += $quantity;
        } else {
            $cartItem = new WineryCartItem([
                'vendor_wine_id' => $vendor_wine_id,
                'quantity' => $quantity,
                'vendor_id' => $vendorid
            ]);

            $cart->items()->save($cartItem);
        }

        $cartItem->save();
    }

    public function removeItem($cart, $vendor_wine_id, $shopid, $vendorid = null)
    {
        $cart->items()->where('vendor_wine_id', $vendor_wine_id)
            ->delete();
    }

    public function clearCart($cart)
    {
        $cart->items()->delete();
    }

    public function updateItemQuantity($cart, $vendor_wine_id, $quantity, $vendorid = null)
    {
        $cartItem = $cart->items()->where('vendor_wine_id', $vendor_wine_id)->first();
        if ($cartItem) {
            $cartItem->quantity = $quantity;
            $cartItem->save();
        }
    }

    public function getTotal($cart)
    {
        return $cart->items->sum(function ($item) {
            return $item->vendor_wine->price * $item->quantity;
        });
    }

    public function getItemCount($cart)
    {
        return $cart->items()->count();
    }

    public function getItemQuantityInCart($cart, $wineId)
    {
        $item = $cart->items()->where('vendor_wine_id', $wineId)->first();
        return $item ? $item->quantity : 0;
    }
}
