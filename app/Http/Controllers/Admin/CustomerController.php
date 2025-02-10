<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Customer;

class CustomerController extends Controller
{
    public function search(Request $request)
    {
        $term = $request->get('term');

        $customers = Customer::where('email', 'LIKE', "%{$term}%")
            ->select('id', 'firstname', 'lastname', 'email')
            ->limit(10)
            ->get();

        return response()->json($customers);
    }
}
