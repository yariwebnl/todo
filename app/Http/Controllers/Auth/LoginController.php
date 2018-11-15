<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\User;

class LoginController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Login Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles authenticating users for the application and
    | redirecting them to your home screen. The controller uses a trait
    | to conveniently provide its functionality to your applications.
    |
    */


    use AuthenticatesUsers;

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    protected $redirectTo = '/home';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function redirectToProvider()
    {
        return Socialite::driver('google')
            ->scopes(['openid', 'profile', 'email'])
            ->redirect();
    }

    public function handleProviderCallback()
    {
        $user = Socialite::driver('google')->user();

        //dd($user);
        // $user->token;
            $logincheck =\DB::table('users')->where('email', $user['emails'][0]['value'])->first();
            if ($logincheck === null) {
                //user bestaand niet nieuwe word aangemaakt
                $user = $user->user;
            }
            else {
                //user word ingelogd
                $user = User::find($logincheck->id);
                Auth::login($user);
                return redirect('../../todo/public')->with('data', [$user->{'name'}]);
            }
    }
}
