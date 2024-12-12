<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Artisan;

use Illuminate\Http\Request;

class CommandController extends Controller
{
    public function sendWeeklyRegisteredUsers()
    {
        Artisan::call('email:weekly-registered-users');
        return response()->json(['message' => 'Weekly email sent successfully']);
    }
}
