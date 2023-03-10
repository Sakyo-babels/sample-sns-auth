<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Laravel\Socialite\Facades\Socialite;
use App\Models\User;

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
    protected $redirectTo = RouteServiceProvider::HOME;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    protected function authenticated(Request $request, $user)
    {
        return $user;
    }

    protected function loggedOut(Request $request)
    {
        $request->session()->regenerate();
        return response()->json();
    }

    public function redirectToProvider(string $provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    public function handleProviderCallback(Request $request, string $provider)
    {
        try {
            $providerUser = Socialite::driver($provider)->stateless()->user();
        } catch (\Exception $e) {
            return redirect('/')->with([
                'get_user_failure' => 'ユーザー情報の取得に失敗しました。'
            ]);
        }

        // dd($providerUser, $providerUser->getName(), $providerUser->getEmail(), $providerUser->getId());

        if ($provider == 'line') {
            $user = User::where('line_user_id', $providerUser->getId())->first();
            if (!$user) {
                $user = new User;
                $user->name  = $providerUser->getName();
                $user->line_user_id  = $providerUser->getId();
                $user->save();
            }
        } else {
            $user = User::where('email', $providerUser->getEmail())->first();
        }

        if ($user) {
            $this->guard()->login($user, true);
            // return $this->sendLoginResponse($request);
            return redirect('/');
        }

        return redirect('/register')->with([
            'no_user' => 'ユーザーが存在しません。'
        ]);
    }
}
