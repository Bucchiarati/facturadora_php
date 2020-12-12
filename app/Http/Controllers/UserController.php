<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Crypt;

class UserController extends Controller
{
    public function index(Request $request)
    {

        if (isset($request->id)) {
            $users = User::where('id', $request->id)->paginate(0);

        } else {
            $users = User::paginate(4);
        }
        return view('dashboard.administrador.usuarios')
            ->with([
                'users' => $users
            ]);
    }

    public function add(Request $request)
    {
        $nuevo = new User();

        $nuevo->id = $request->id;
        $nuevo->name = strtoupper($request->name);
        $nuevo->lstname = strtoupper($request->lstname);
        $nuevo->email = 'usuario@usuario.com';
        $nuevo->password = Crypt::encryptString($request->password);
        $nuevo->role = $request->rol;
        $nuevo->created_at = date('Y-m-d');
        $nuevo->photo = null;

        if(User::find($nuevo->id) || $nuevo->id == null || $nuevo->name == null
            || $nuevo->password == null || $nuevo->lstname == null || $nuevo->role == null)
        {
            return back()->withErrors(['fail' => true]);
        }else
        {
            $nuevo->save();
            return back()->withErrors(['save' => true]);
        }
    }

    public function modify(Request $request)
    {
        var_dump($request->toArray()); die();
    }

    public function delete(Request $request)
    {
        $user = User::find($request->id);
        $user->delete();
        return back()->withErrors(['delete' => true]);
    }
}