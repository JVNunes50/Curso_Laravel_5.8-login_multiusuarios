<?php

namespace App\Http\Controllers\Auth;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class AdminLoginController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest:admin');
    }

    public function login(Request $request){
        $request->validate([
            $this->username() => 'required|string',
            'password' => 'required|string',
        ]);

        $credenciais = [
            'email' => $request->email,
            'password' => $request->password,
        ];

        $authOK = Auth::guard('admin')->attempt($credenciais, $request->remember);

        if ($authOK) {
            return redirect()->intended(route('admin.dashboard'));
        }
        
        return redirect()->back()->withInput($request->only('email', 'remember'));
    }

    public function index(){
        return view('auth.admin-login');
    }
}
