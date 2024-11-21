<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class WineController extends Controller
{
    public function index() {
        return view('admin.wines.index');
    }    
}