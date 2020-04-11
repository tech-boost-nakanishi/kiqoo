<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class RankController extends Controller
{
    public function index(Request $request)
    {
    	return view('ranking');
    }
}
