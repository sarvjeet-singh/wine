<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Laravel\Socialite\Facades\Socialite;
use App\Models\Customer;
use Illuminate\Support\Facades\Auth;
use Session;

class GoogleController extends Controller
{
    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback()
    {
        try {
            $user = Socialite::driver('google')->stateless()->user();
            $findUser = Customer::where('email', $user->email)->first();

            if ($findUser) {
                Auth::login($findUser);
            } else {
                if(isset($user->name) && !empty($user->name)){
                    $name = explode(' ', $user->name);
                    $user->firstname = $name[0];
                    $user->lastname = $name[1];
                }
                Session::put('user', $user);
                return view('auth.register-social', ['user' => $user]);
            }

            return redirect()->intended('user-dashboard');
        } catch (\Exception $e) {
            return redirect('login')->withErrors(['error' => 'Unable to login with Google']);
        }
    }
}
