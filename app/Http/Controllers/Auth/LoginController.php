<?php

namespace App\Http\Controllers\Auth;

use App\Benchmark;
use App\Http\Controllers\Controller;
use App\Invitation;
use App\User;
use Auth;
use Carbon\Carbon;
use Session;
use Socialite;

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

    public function redirectToProvider($provider)
    {
        return Socialite::driver($provider)->redirect();
    }

    /**
     * Obtain the user information from provider.  Check if the user already exists in our
     * database by looking up their provider_id in the database.
     * If the user exists, log them in. Otherwise, create a new user then log them in. After that
     * redirect them to the authenticated users homepage.
     *
     * @return Response
     */
    public function handleProviderCallback($provider)
    {
        try {
            $user = Socialite::driver($provider)->user();
        } catch (\Exception $e) {
            Session::flash('canceled', true);
            Session::flash('msg', ['class' => 'danger', 'msg' => "Sorry, Authentication is required"]);
            return redirect('/');
        }
        $bench_id = Session::get('benchmark');

        $authUser = $this->findOrCreateUser($user, $provider);

        Auth::login($authUser, true);

        // check if user added a benchmark before login
        // if yes , set the relationship

        if (!is_null($bench_id)) {
            $benchmark = Benchmark::find(Session::get('benchmark'));
            if (!is_null($benchmark)) {
                $benchmark->user_id = Auth::id();
                $benchmark->save();
                Session::forget('benchmark');
                Session::put('new_benchmark', $bench_id);
                $invite_id = Session::get('used_invitation');

                if (!is_null($invite_id)) {
                    Session::forget('used_invitation');
                    $invitation = Invitation::find($invite_id);
                    $invitation->invited_id = Auth::id();
                    if (!is_null($authUser->email)) {
                        $invitation->invited_email = $authUser->email;
                    }
                    $invitation->used_at = Carbon::now();
                    $invitation->save();
                }
            }

            return redirect('/benchmarks/' . $bench_id);
        }

        return redirect($this->redirectTo);
    }

    /**
     * If a user has registered before using social auth, return the user
     * else, if user tested the app but didnt register, register him  and return user object
     * else create user and return object
     * @param  $user Socialite user object
     * @param $provider Social auth provider
     * @return  User
     */
    public function findOrCreateUser($user, $provider)
    {
        $authUser = User::where('provider_id', $user->id)->first();

        if ($authUser && isset($authUser->provider_id)) {
            $authUser->token = $user->token;
            $authUser->save();
            return $authUser;
        }
        if ($authUser && is_null($authUser->provider_id)) {
            $authUser->name = $user->name;
            $authUser->email = $user->email;
            $authUser->token = $user->token;
            $authUser->provider = $provider;
            $authUser->provider_id = $user->id;
            $authUser->save();

            return $authUser;
        }
        Session::flash('CompleteRegistration', true);
        return User::create([
            'name' => $user->name,
            'email' => $user->email,
            'token' => $user->token,
            'provider' => $provider,
            'provider_id' => $user->id,
        ]);
    }

    public function logout()
    {
        auth()->logout();
        return redirect('/');
    }
}
