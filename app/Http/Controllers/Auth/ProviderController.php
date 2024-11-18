<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

class ProviderController extends Controller
{
    public function redirect($provider)
    {
                /** @disregard Silence the stateless error, since it does work fine but its not recognized by intelliphense*/

        return Socialite::driver($provider)->stateless()->redirect();
    }

    //callback function
    public function callback($provider)
    {
        /** @disregard Silence the stateless error, since it does work fine but its not recognized by intelliphense*/
        $socialUser = Socialite::driver($provider)->stateless()->user();
        // Check if the user is in the Discord guild
        $user = User::where('provider_id', $socialUser->id)->first();


        dd($socialUser);
        $user = User::updateOrCreate(
            [
                'provider_id' => $socialUser->id, // Condition to check existing user
                'provider' => $provider // It's often wise to include the provider in the check
            ],
            [
                'name' => $socialUser->user["name"], // Data to update or create
                'email' => $socialUser->email,
                'provider_token' => $socialUser->token,
                'provider_refresh_token' => $socialUser->refreshToken
            ]
        );

        $user->save();
        auth()->login($user);




    }
}