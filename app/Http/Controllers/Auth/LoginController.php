<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;

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
    protected $redirectTo = '/';

    protected function redirectTo($request)
    {
        if(Auth::user()->email_verified_at !== null){
            if(Cookie::get('redirectafterregister') !== null){
                $questionid = Cookie::get('redirectafterregister');
                Cookie::queue(Cookie::forget('redirectafterregister'));
                return redirect()->action('AnswerController@add', ['id' => $questionid])->with('login', 'ログインしました。');
            }else{
                return redirect()->action('ProfileController@show', ['id' => Auth::user()->id])->with('login', 'ログインしました。');
            }
        }else{
            $this->guard()->logout($this->guard()->user());
            return view('auth.register_emailcheck_success');
        }
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
