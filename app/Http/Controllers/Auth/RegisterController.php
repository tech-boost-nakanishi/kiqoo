<?php

namespace App\Http\Controllers\Auth;

use App\User;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Illuminate\Foundation\Auth\RegistersUsers;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Mail\RegisterMail;
use Cookie;

class RegisterController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Register Controller
    |--------------------------------------------------------------------------
    |
    | This controller handles the registration of new users as well as their
    | validation and creation. By default this controller uses a trait to
    | provide this functionality without requiring any additional code.
    |
    */

    use RegistersUsers;

    public function register(Request $request)
    {
        $this->validator($request->all())->validate();

        $user = User::where('email', $request->email)->where('email_verify_token', $request->email_token)->first();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        $this->guard()->login($user);

        if(Cookie::get('redirectafterregister') !== null){
            $questionid = Cookie::get('redirectafterregister');
            Cookie::queue(Cookie::forget('redirectafterregister'));
            return $this->registered($request, $user)
                        ?: redirect()->action('AnswerController@add', ['id' => $questionid])->with('register', '登録ありがとうございます。');
        }else{
            return $this->registered($request, $user)
                        ?: redirect()->action('ProfileController@show', ['id' => Auth::user()->id])->with('register', '登録ありがとうございます。');
        }
    }

    /**
     * Where to redirect users after registration.
     *
     * @var string
     */
    protected $redirectTo = '/';

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest');
    }

    /**
     * Get a validator for an incoming registration request.
     *
     * @param  array  $data
     * @return \Illuminate\Contracts\Validation\Validator
     */
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'min:6', 'max:255', 'unique:users', 'regex:/^[a-zA-Z0-9]+$/'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);
    }

    /**
     * Create a new user instance after a valid registration.
     *
     * @param  array  $data
     * @return \App\User
     */
    protected function create(array $data)
    {
        return User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => Hash::make($data['password']),
        ]);
    }

    public function add()
    {
        return view('auth.register_emailcheck');
    }

    public function emailcheck(Request $request)
    {
        $rules = [
            'email' => 'required|email|unique:users',
        ];
        $messages = [
            'email.required' => 'メールアドレスを入力してください。',
            'email.email' => '正しいメールアドレスを入力してください。',
            'email.unique' => 'このメールアドレスは存在します。',
        ];
        $validator = Validator::make($request->all(), $rules, $messages);
        $validated = $validator->validate();

        $email_verify_token = Hash::make(str_random(40));
        $email_verify_token = str_replace('/', '.', $email_verify_token);
        $user = new User;
        $user->email = $request->email;
        $user->email_verify_token = $email_verify_token;
        $user->save();

        Mail::to($user->email)
        ->send(new RegisterMail(
            $user = $user,
        ));

        return view('auth.register_emailcheck_success');
    }

    public function maincheck($email, $token)
    {
        $user = User::where('email', $email)->where('email_verify_token', $token)->first();
        if($user !== null && empty($user->name)){
            return view('auth.register', ['email' => $user->email , 'email_token' => $token]);
        }else{
            abort(404);
        }
    }

    public function mainregister(Request $request)
    {
        $user = User::where('email', $request->$email)->where('email_verify_token', $token)->first();
        $user->name = $request->name;
        $user->password = Hash::make($request->password);
        $user->save();

        $this->guard()->login($user);

        if(Cookie::get('redirectafterregister') !== null){
            $questionid = Cookie::get('redirectafterregister');
            Cookie::queue(Cookie::forget('redirectafterregister'));
            return $this->registered($request, $user)
                        ?: redirect()->action('AnswerController@add', ['id' => $questionid])->with('register', '登録ありがとうございます。');
        }else{
            return $this->registered($request, $user)
                        ?: redirect()->action('ProfileController@show', ['id' => Auth::user()->id])->with('register', '登録ありがとうございます。');
        }
    }
}
