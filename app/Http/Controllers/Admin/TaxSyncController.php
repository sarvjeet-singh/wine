<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\StripeSyncService;
use Illuminate\Http\Request;

class TaxSyncController extends Controller
{
    protected $stripeSyncService;

    public function __construct(StripeSyncService $stripeSyncService)
    {
        $this->stripeSyncService = $stripeSyncService;
    }

    public function sync()
    {
        $result = $this->stripeSyncService->syncTaxes();

        if ($result['success']) {
            return redirect()->route('admin.taxes.index')
                ->with('success', $result['message'] . ' Synced ' . $result['synced_count'] . ' plans.');
        }

        return redirect()->route('admin.taxes.index')
            ->with('error', $result['message']);
    }

    public function index()
    {
        return view('admin.stripe.taxes.sync');
    }
}
