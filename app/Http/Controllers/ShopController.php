<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index()
    {
        return view('FrontEnd.shop.index');
    }

    public function products()
    {
        return view('FrontEnd.shop.products');
    }
    

    public function productDetail()
    {
        return view('FrontEnd.shop.product-detail');
    }
}
