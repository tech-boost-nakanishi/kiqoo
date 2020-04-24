<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RedirectsUsers, ThrottlesLogins;
use Cookie;
use App\User;
use Socialite;
use Carbon\Carbon;

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

    public function showLoginForm(Request $request)
    {
        if(isset($request->redirectafterregister)){
            Cookie::queue('redirectafterregister', $request->redirectafterregister, 30);
        }
        return view('auth.login');
    }

    /**
     * Where to redirect users after login.
     *
     * @var string
     */
    //protected $redirectTo = '/';

    protected function sendLoginResponse(Request $request)
    {
        $request->session()->regenerate();

        $this->clearLoginAttempts($request);

        if(Auth::user()->email_verified_at !== null){
            if(Cookie::get('redirectafterregister') !== null){
                $questionid = Cookie::get('redirectafterregister');
                Cookie::queue(Cookie::forget('redirectafterregister'));
                return $this->authenticated($request, $this->guard()->user())
                    ?: redirect()->action('AnswerController@add', ['id' => $questionid])->with('login', 'ログインしました。');
            }else{
                return $this->authenticated($request, $this->guard()->user())
                    ?: redirect()->action('ProfileController@show', ['id' => Auth::user()->id])->with('login', 'ログインしました。');
            }
        }else{
            $this->guard()->logout($this->guard()->user());
            return view('auth.register_emailcheck_success');
        }
    }

    public function redirectToGoogle()
    {
        return Socialite::driver('google')->redirect();
    }

    public function handleGoogleCallback(Request $request)
    {
        $gUser = Socialite::driver('google')->stateless()->user();
        
        $user = User::where('email', $gUser->email)->first();
        
        if ($user === null) {
            $user = $this->createUserByGoogle($gUser);
        }
        
        \Auth::login($user, true);
        return $this->sendLoginResponse($request);
    }

    public function createUserByGoogle($gUser)
    {
        $user = User::create([
            'name'     => $gUser->email,
            'email'    => $gUser->email,
            'password' => \Hash::make(str_random(40)),
        ]);
        $user->email_verified_at = Carbon::now();
        $user->save();
        return $user;
    }

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }
}
