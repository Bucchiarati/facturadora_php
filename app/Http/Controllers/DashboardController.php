<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index(Request $request)
    {
        if (isset($request->id))
        {
            $users = User::where('id',$request->id)->paginate(0);

        }else
        {
            $users = User::paginate(6);
        }
        return view('dashboard.dash')
            ->with([
                'users' => $users,
                'title' => 'Panel de Administración'
            ]);
    }
}
