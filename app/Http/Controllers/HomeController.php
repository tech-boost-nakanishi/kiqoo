<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Auth;

use App\User;

use Storage;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        return redirect('/');
    }

    public function logout()
    {
        Auth::logout();
        return redirect('/')->with('logout', 'ログアウトしました。');
    }

    public function cancel()
    {
        return view('auth.cancel');
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $image = explode("/", $user->image_path);
        $img = end($image);
        if($img != "BIkd1g42sDeFjUxxXr5ydLfOBSBNMxQffv6xT7xX.jpeg"){
            $disk = Storage::disk('s3');
            $disk->delete($img);
        }
        $user->delete();
        return redirect('/')->with('cancel', 'ご利用ありがとうございました。');
    }
}
