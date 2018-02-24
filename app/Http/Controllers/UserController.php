<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
Use Auth;
class UserController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        //$this->middleware('auth');
    }

    /**
     * Show the doLogin.
     *
     * @return \Illuminate\Http\Response
     */
    public function doLogin(Request $request)
    {  if (Auth::attempt($request->input())) {
			return response()->json(['status'=>1 , 'user' => Auth::user()]);
		}else{
			return response()->json(['status'=>0]);
		}
    }
}
