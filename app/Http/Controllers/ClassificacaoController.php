<?php

namespace App\Http\Controllers;



use App\Http\Requests\Classificacao\StoreClassificacaoRequest;
use App\Http\Requests\Classificacao\UpdateClassificacaoRequest;
use App\Models\Classificacao;
use App\Models\Patrimonio;
use App\Models\Subgrupo;
use Illuminate\Http\Request;

class ClassificacaoController extends Controller
{
    public function index(){
        $classificacaos = Classificacao::paginate(10);
        return view('classificacao.index', compact('classificacaos'));
    }

    public function create()
    {
        return view('classificacao.create');
    }

    public function store(StoreClassificacaoRequest $request)
    {
        classificacao::create($request->all());
        return redirect(route('classificacao.index'))->with('success', 'Classificação Cadastrada com Sucesso!');
    }

    public function edit($classificacao_id)
    {
        $classificacao = classificacao::find($classificacao_id);
        return view('classificacao.edit', compact('classificacao'));
    }

    public function update(UpdateClassificacaoRequest $request)
    {
        Classificacao::find($request->classificacao_id)->update($request->all());
        return redirect(route('classificacao.index'))->with('success', 'Classificação Editada com Sucesso!');
    }

    public function delete($classificacao_id)
    {
        $classificacao = Classificacao::find($classificacao_id);

        if(!$classificacao->subgrupos()->exists()){
            $classificacao->delete();

            return redirect(route('classificacao.index'))->with('success', 'Classificação Removida com Sucesso!');
        }else{
            return redirect()->route('classificacao.index')->with('fail', 'Não é possivel remover esta classificação, há subgrupos vinculados a ela!');
        }
    }

    public function search(Request $request)
    {
        $classificacaos = Classificacao::where('nome', 'ilike', "%$request->busca%")->paginate(10);

        return view('classificacao.index', compact('classificacaos'));
    }
}
