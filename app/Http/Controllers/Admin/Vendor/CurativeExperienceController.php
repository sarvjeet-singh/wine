<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;


class CurativeExperienceController extends Controller
{
    public function index()
    {
        return view('admin.vendor.curative-experience.index');
    }
}