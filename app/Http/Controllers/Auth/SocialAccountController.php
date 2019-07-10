<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\LinkedSocialAccount;
use Auth;
// use App\SocialAccountService;

class SocialAccountController extends Controller
{
    /**
     * Redirect the user to the GitHub authentication page.
     *
     * @return Response
     */
    public function redirectToProvider($provider)
    {
        return \Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = \Socialite::with($provider)->user();
        } catch (\Exception $e) {
            return redirect('/');
        }

        $account = LinkedSocialAccount::where('provider_name', $provider)
                   // ->where('provider_id', $user->getId())
                   ->first();
                   // dd($account);

        if ($account) {
            auth()->login($account->user, true);
        } else {

            $user = User::where('email', $providerUser->getEmail())->first();

            if (! $user) {
                $user = User::create([  
                    'email' => $providerUser->getEmail(),
                    'name'  => $providerUser->getName(),
                    // 'profile_image' => $providerUser->->getAvatar(),
                ]);
            }

            $user->accounts()->create([
                'provider_id'   => $providerUser->getId(),
                'provider_name' => $provider,
            ]);

            auth()->login($user, true);

        }

        // $authUser = $accountService->findOrCreate(
        //     $user,
        //     $provider
        // );

        

        return redirect('/');
    }

}
