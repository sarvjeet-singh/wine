<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DB;

class UserEmailController extends Controller
{
    // Fetch users for the admin to select
    public function getUsers($id)
    {

        $users = User::select('id', DB::raw("CONCAT(firstname, ' ', lastname) AS name"), 'email')->where('id', $id)->get();
        return response()->json(['users' => $users]);
    }

    // Update a user's email
    public function updateUserEmail(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'user_id' => 'required|exists:users,id',
            'email' => 'required|email|unique:users,email,' . $request->user_id,
        ]);

        if ($validator->fails()) {
            return response()->json([
                'errors' => $validator->errors(),
            ], 422);
        }

        $user = User::findOrFail($request->user_id);
        $user->email = $request->email;
        $user->save();

        return response()->json(['message' => 'Email updated successfully.']);
    }
}
