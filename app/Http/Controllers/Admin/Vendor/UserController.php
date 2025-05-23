<?php

namespace App\Http\Controllers\Admin\Vendor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Category;
use App\Models\Vendor;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use App\Mail\VendorUserMail;

class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $categories = Category::where('status', 1)->get();
        $query = User::query();

        // Check if a search query exists
        if ($request->has('q') && !empty($request->q)) {
            $search = $request->q;
            $query->where(function ($q) use ($search) {
                $q->where('firstname', 'LIKE', "%{$search}%")
                    ->orWhere('lastname', 'LIKE', "%{$search}%")
                    ->orWhereRaw("CONCAT(firstname, ' ', lastname) LIKE ?", ["%{$search}%"])
                    ->orWhere('email', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->paginate(10);
        $total = $query->count();

        return view('admin.vendors.users.index', compact('users', 'categories', 'total'));
    }

    public function create()
    {
        $vendors = Vendor::all();
        return view('admin.vendors.users.create', compact('vendors'));
    }

    public function store(Request $request)
    {
        $request->merge([
            'master_user' => $request->has('master_user') ? 1 : 0
        ]);
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'contact_number' => 'required|string|max:20',
            'password' => 'required|string|min:8',
            'master_user' => 'nullable|boolean',
            'vendor_id' => 'required_if:master_user,0|array|min:1',  // Allow it to be null
            'vendor_id.*' => 'exists:vendors,id', // Check each vendor ID exists
        ], [
            'vendor_id.required' => 'Please select at least one vendor.',
            'vendor_id.required_if' => 'Please select at least one vendor if the user is not a master user.',
            'vendor_id.*.exists' => 'One or more selected vendors are invalid.',
        ]);

        // Check if any of the selected vendors are already assigned to another user
        if (!empty($request->vendor_id)) {
            $existingVendor = Vendor::whereIn('id', $request->vendor_id)
                ->whereNotNull('user_id')
                ->first();

            if ($existingVendor) {
                return redirect()->back()->withErrors(['vendor_id' => 'One or more selected vendors are already assigned to another user.']);
            }
        }

        $user = User::create([
            'firstname' => $request->firstname,
            'lastname' => $request->lastname,
            'email' => $request->email,
            'contact_number' => $request->contact_number,
            'password' => bcrypt($request->password),
            'master_user' => $request->master_user ?? 0,
        ]);

        // Update vendors with the new user ID
        if (!empty($request->vendor_id)) {
            Vendor::whereIn('id', $request->vendor_id)->update(['user_id' => $user->id]);
        }

        // Send email with credentials
        $to = $user->email;
        $subject = "Your new account credentials";
        $password = $request->password;

        Mail::to($to)->send(new VendorUserMail($user, $password, 'emails.vendor.vendor_user_login_details_email', $subject));

        return redirect()->route('admin.vendors.users.index')->with('success', 'User added successfully!');
    }


    public function edit($id)
    {
        $user = User::find($id);
        $vendors = Vendor::all();
        return view('admin.vendors.users.create', compact('user', 'vendors'));
    }

    public function show($id)
    {
        $user = User::find($id);
        return view('admin.vendors.users.show', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        $request->merge([
            'master_user' => $request->has('master_user') ? 1 : 0
        ]);
        $request->validate([
            'firstname' => 'required|string|max:255',
            'lastname' => 'required|string|max:255',
            //'email' => 'required|email|unique:users,email,' . $user->id,
            'contact_number' => 'required|string|max:20',
            'vendor_id' => 'required_if:master_user,0|array|min:1',
            'master_user' => 'nullable|boolean',
            'vendor_id.*' => 'exists:vendors,id', // Validate vendor existence
        ],[
            'vendor_id.required' => 'Please select at least one vendor.',
            'vendor_id.required_if' => 'Please select at least one vendor if the user is not a master user.',
            'vendor_id.*.exists' => 'One or more selected vendors are invalid.',
        ]);

        DB::beginTransaction();
        try {
            // Check if any of the selected vendors are already assigned to another user
            if (!empty($request->vendor_id)) {
                $existingVendor = Vendor::whereIn('id', $request->vendor_id)
                    ->whereNot('user_id', $user->id) // Exclude current user
                    ->whereNotNull('user_id')
                    ->first();

                if ($existingVendor) {
                    return redirect()->back()->withErrors(['vendor_id' => 'One or more selected vendors are already assigned to another user.']);
                }
            }

            // Update user details
            $user->update([
                'firstname' => $request->firstname,
                'lastname' => $request->lastname,
                //'email' => $request->email,
                'contact_number' => $request->contact_number,
                'master_user' => $request->master_user ?? 0,
                'password' => !empty($request->password) ? bcrypt($request->password) : $user->password,
            ]);

            // Remove previous vendor associations
            Vendor::where('user_id', $user->id)->update(['user_id' => null]);

            // If vendors are provided, assign them to the user
            if (!empty($request->vendor_id)) {
                Vendor::whereIn('id', $request->vendor_id)->update(['user_id' => $user->id]);
            }

            DB::commit();

            // Send email if password is updated
            if (!empty($request->password)) {
                $to = $user->email;
                $subject = "Your new account credentials";
                $password = $request->password;
                Mail::to($to)->send(new VendorUserMail($user, $password, 'emails.vendor.vendor_user_login_details_email', $subject));
            }

            return redirect()->route('admin.vendors.users.index')->with('success', 'User updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Something went wrong! ' . $e->getMessage());
        }
    }


    public function destroy($id)
    {
        try {
            $user = User::findOrFail($id);

            // Check if the user still has vendors
            $vendorsCount = Vendor::where('user_id', $user->id)->count();
            if ($vendorsCount > 0) {
                return response()->json([
                    'message' => 'Cannot delete contact. Please unlink all associated vendors first.'
                ], 400);
            }

            // Delete the user
            $user->delete();

            return response()->json([
                'message' => 'User deleted successfully.'
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Failed to delete user.',
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function search(Request $request)
    {
        $term = $request->get('query');

        $users = User::where('email', 'LIKE', "%{$term}%")
            ->select('id', DB::raw("CONCAT(firstname, ' ', lastname) as name"), 'email')
            ->limit(10)
            ->get();

        return response()->json($users);
    }
}
