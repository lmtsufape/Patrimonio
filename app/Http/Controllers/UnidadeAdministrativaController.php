<?php

namespace App\Http\Controllers;


use App\Http\Requests\UnidadeAdmin\StoreUnidadeAdministrativaRequest;
use App\Http\Requests\UnidadeAdmin\UpdateUnidadeAdministrativaRequest;
use App\Models\Patrimonio;
use App\Models\Predio;
use Illuminate\Http\Request;
use App\Models\UnidadeAdministrativa;

class UnidadeAdministrativaController extends Controller
{
    public function index($unidade_admin_pai_id = null)
    {
        $unidades = UnidadeAdministrativa::paginate(10);
        $unidadesAll = UnidadeAdministrativa::orderBy('nome');
        $predios = Predio::all();
        
        return view('unidade_admin.index', compact('unidades', 'predios', 'unidadesAll'));
    }

    public function create($unidade_admin_pai_id = null)
    {
        if ($unidade_admin_pai_id != null) {
            $unidade_admin_pai = UnidadeAdministrativa::find($unidade_admin_pai_id);
            return view('unidade_admin.create', compact('unidade_admin_pai'));
        }
        return view('unidade_admin.create');

    }

    public function store(StoreUnidadeAdministrativaRequest $request)
    {
        UnidadeAdministrativa::create($request->all());
        return redirect(route('unidade.index'))->with('success', 'Unidade Administrativa Cadastrada com Sucesso!');
    }

    public function edit($unidade_admin_id)
    {
        $unidades = UnidadeAdministrativa::find($unidade_admin_id);
        return view('unidade.edit', compact('unidades'));
    }

    public function update(UpdateUnidadeAdministrativaRequest $request, $id)
    {
        UnidadeAdministrativa::find($id)->update($request->all());
        return redirect(route('unidade.index'))->with('success', 'Unidade Administrativa Editada com Sucesso!');
    }

    public function delete($unidade_admin_id)
    {
        $unidade_admin = UnidadeAdministrativa::find($unidade_admin_id);
        $patrimonio = Patrimonio::where('unidade_admin_id', $unidade_admin_id)->first();

        if ($patrimonio == null) {
            $unidade_admin_filho = UnidadeAdministrativa::where('unidade_admin_pai_id', $unidade_admin_id)->first();
            
            if ($unidade_admin_filho) {
                return redirect()->back()->with('fail', 'Não é possivel remover a unidade administrativa, existem sub-unidades vinculadas a ela!');
            }

            $unidade_admin->delete();
            
            return redirect(route('unidade.index'))->with('success', 'Unidade Removida com Sucesso!');
        } else {
            return redirect(route('unidade.index'))->with('fail', 'Não é possivel remover a unidade, existem patrimônios vinculados a ela!');

        }

    }

    public function search(Request $request)
    {
        $unidades = UnidadeAdministrativa::where('nome', 'ilike', "%$request->busca%")->paginate(10);

        return view('unidade_admin.index', compact('unidades'));
    }
}
