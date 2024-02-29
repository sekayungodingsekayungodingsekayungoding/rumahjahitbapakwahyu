<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    public function proseslogin(Request $request)
    {
       if (Auth::guard('buy')->attempt([
        'username'      => $request->username,
        'password'     => $request->password
       ])) {
           return redirect('/dashboard');
       }else{
           return redirect('/')->with(['warning' => 'NIK / Password Salah !!']);
       }
    }

    public function proseslogout()
    {
        if(Auth::guard('buy')->check()){
            Auth::guard('buy')->logout();
            return redirect('/');
        }
    }

    public function loginadmin(Request $request)
    {
        if (Auth::guard('user')->attempt([
            'email'      => $request->email,
            'password'   => $request->password
           ])) {
               return redirect('panel/dashboardadmin');
        }else{
            return redirect('/panel')->with(['warning' => 'Email / Password Salah !!']);
        }
    }

    public function proseslogoutadmin()
    {
        if(Auth::guard('user')->check()){
            Auth::guard('user')->logout();
            return redirect('/');
        }
    }
}
