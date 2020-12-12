<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Crypt;

class LoginController extends Controller
{

    public function __construct()
    {
        $this->middleware('guest', ['only' => 'showLogin']);
    }

    public function login()
    {

        $credentials = $this->validate(request(),[
            'id' => 'required|string',
            'password' => 'required|string'
        ]);

        $user = User::where('id', $credentials['id'])->first();

        if ($user)
        {
            if (Crypt::decryptString($user->password) == $credentials['password'])
            {
                Auth::login($user);
                return redirect()->route('dashboard');
            }
        }

        /*
        if(Auth::attempt($credentials))
        {
            return redirect()->route('dashboard');
        }
        */
        return back()->withErrors(['fail' => 'true']);
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function logout()
    {
        Auth::logout();

        return redirect('/');
    }
}
