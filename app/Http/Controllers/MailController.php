<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Illuminate\Support\Facades\Mail;
use App\Mail\ReviewMail;
use Illuminate\Support\Facades\Auth;

class MailController extends Controller
{
    public function reviewmail()
    {
    	$name = Auth::user()->name;
	    $text = 'これからもよろしくお願いいたします。';
	    $to = Auth::user()->email;
	    Mail::to($to)->send(new ReviewMail($name, $text));
	    return redirect('/');
    }
}
