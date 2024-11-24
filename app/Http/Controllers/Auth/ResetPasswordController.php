<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Password;

class ResetPasswordController extends Controller
{
    use ResetsPasswords;

    protected $redirectTo = '/login';  // Redirect to login after reset

    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Handle a reset password request.
     *
     * @param Request $request
     * @return \Illuminate\Http\RedirectResponse
     */
    protected function reset(Request $request)
    {
        // Perform the password reset logic
        $response = $this->broker()->reset(
            $this->credentials($request), function ($user, $password) {
                $user->password = bcrypt($password);
                $user->save();
            }
        );

        // Check if the reset was successful, redirect to login
        if ($response == Password::PASSWORD_RESET) {
            return redirect()->route('login')->with('success', 'Password has been reset. Please login.');
        }

        // If not successful, redirect back to reset form
        return redirect()->back()->withErrors(['email' => 'The provided password reset token is invalid.']);
    }
}
