<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;
use RedirectsUsers, ThrottlesLogins;
use Cookie;

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

    public function redirectTo()
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
            //Auth::logout();
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
