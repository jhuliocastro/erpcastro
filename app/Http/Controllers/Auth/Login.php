<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function index(){
        return view('Auth.login');
    }

    public function login(Request $request){
        $credentials = [
            'user' => $request->usuario,
            'password' => $request->password
        ];

        if(Auth::attempt($credentials)){
            $request->session()->regenerate();
            $return = [
                'status' => true
            ];
        }else{
            $return = [
                'status' => false
            ];
        }

        return json_encode($return);
    }
}
