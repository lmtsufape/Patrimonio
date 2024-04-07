<?php

namespace App\Http\Controllers;

use App\Models\Patrimonio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */
    public function index()
    {
        $patrimonios = Patrimonio::paginate(2);

        return view('patrimonio.index', compact('patrimonios'));
    }

    public function indexServidor(){
        $patrimonios = Patrimonio::where('servidor_id', Auth::user()->servidor->id)->paginate(2);

        return view('patrimonio.index', compact('patrimonios'));
    }
}
