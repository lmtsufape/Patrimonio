<?php

namespace App\Http\Controllers;

use App\Http\Requests\Subgrupo\StoreSubgrupoRequest;
use App\Http\Requests\Subgrupo\UpdateSubgrupoRequest;
use App\Models\Subgrupo;
use App\Models\Classificacao;
use Illuminate\Http\Request;

class SubgrupoController extends Controller
{
    public function index()
    {
        $subgrupos = Subgrupo::paginate(10);
        $classificacoes = Classificacao::all();
        return view('subgrupo.index', compact('subgrupos', 'classificacoes'));
    }

    public function create()
    {
        return view('subgrupo.create');
    }

    public function store(StoreSubgrupoRequest $request)
    {
        Subgrupo::create($request->all());
        return redirect(route('subgrupo.index'))->with('success', 'Subgrupo cadastrado com sucesso!');
    }

    public function edit($subgrupo_id)
    {
        $subgrupo = Subgrupo::find($subgrupo_id);
        return view('subgrupo.edit', compact('subgrupo'));
    }

    public function update(UpdateSubgrupoRequest $request, $id)
    {
        $subgrupo = Subgrupo::find($id);

        $subgrupo->update($request->all());

        return redirect(route('subgrupo.index'))->with('success', 'Subgrupo editado com sucesso!');
    }



    public function delete($subgrupo_id)
    {
        $subgrupo = Subgrupo::find($subgrupo_id);

        if ($subgrupo->patrimonios()->exists()) {
            return redirect()->back()->with('fail', 'Não é possivel remover este subgrupo, há patrimônios vinculados a ele!');
        }

        $subgrupo->delete();
        
        return redirect(route('subgrupo.index'))->with('success', 'Subgrupo removido com sucesso!');
    }



    public function search(Request $request)
    {
        $classificacoes = Classificacao::all();
        $subgrupos = Subgrupo::where('nome', 'ilike', "%$request->busca%")->paginate(10);
        return view('subgrupo.index', compact('subgrupos', 'classificacoes'));
    }
}
