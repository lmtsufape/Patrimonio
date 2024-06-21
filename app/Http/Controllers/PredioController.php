<?php

namespace App\Http\Controllers;

use App\Http\Requests\Predio\StorePredioRequest;
use App\Http\Requests\Predio\UpdatePredioRequest;
use App\Models\Predio;
use App\Models\Sala;
use Illuminate\Http\Request;

class PredioController extends Controller
{
    public function index()
    {
        $predios = Predio::paginate(10);
        return view('predio.index', compact('predios'));
    }

    public function store(StorePredioRequest $request)
    {
        Predio::create($request->all());
        return redirect(route('predio.index'))->with('success', 'Prédio Cadastrado com Sucesso!');
    }

    public function update(UpdatePredioRequest $request, $id)
    {
        Predio::find($id)->update($request->all());

        return redirect(route('predio.index'))->with('success', 'Predio Editado com Sucesso!');
    }

    public function delete($predio_id)
    {
        $predio = Predio::find($predio_id);
        $salas = Sala::where('predio_id', $predio->id)->first();
        if ($salas == null) {
            $predio->delete();
            return redirect(route('predio.index'))->with('success', 'Prédio Removido com Sucesso!');
        } else {
            return redirect(route('predio.index'))->with('fail', 'É Necessário Remover Todas as Salas do Prédio Antes!');
        }
    }

    public function busca(Request $request)
    {
        $termo = $request->input('busca');
        $predios = Predio::busca($termo);

        return view('predio.index', compact('predios'));
    }
}
