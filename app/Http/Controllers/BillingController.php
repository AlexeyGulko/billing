<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class BillingController extends Controller
{
    public function index()
    {
        return view('index');
    }

    public function register(Request $request)
    {
        return $request->wantsJson()
            ? response()->json()
            : response()->view('welcome')
        ;
    }
}
