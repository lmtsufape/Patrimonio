<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function invalidUser()
    {
        return view('auth.invalid-user');
    }

    public function home()
    {
        return redirect()->route('patrimonio.index');
    }
}
