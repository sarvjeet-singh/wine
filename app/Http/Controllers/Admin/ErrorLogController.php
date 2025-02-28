<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ErrorLog;
use Illuminate\Http\Request;

class ErrorLogController extends Controller
{
    public function index(Request $request)
    {
        $query = ErrorLog::latest();

        if ($request->has('level') && !empty($request->level)) {
            $query->where('level', $request->level);
        }
        $logs = $query->orderBy('id', 'desc');
        $logs = $query->paginate(20);
        $levels = ErrorLog::distinct()->pluck('level');

        return view('admin.logs.errors', compact('logs', 'levels'));
    }
}
