<?php

namespace App\Http\Controllers;

use App\Http\Requests\Patrimonio\FilterPatrimonioRequest;
use App\Http\Requests\Patrimonio\StoreCodigoPatrimonioRequest;
use App\Http\Requests\Patrimonio\StorePatrimonioRequest;
use App\Http\Requests\Patrimonio\UpdatePatrimonioRequest;
use App\Models\Classificacao;
use App\Models\Codigo;
use App\Models\MovimentoPatrimonio;
use App\Models\Origem;
use App\Models\Predio;
use App\Models\Sala;
use App\Models\Servidor;
use App\Models\UnidadeAdministrativa;
use App\Models\Situacao;
use Illuminate\Http\Request;
use App\Models\Patrimonio;
use App\Models\Subgrupo;
use Illuminate\Support\Facades\Auth;
use PDF;

class PatrimonioController extends Controller
{
    public function index(FilterPatrimonioRequest $request)
    {
        $predios = Predio::all();
        $servidores = Servidor::all();
        $situacoes = Situacao::all();
        $origens = Origem::all();
        $unidades = UnidadeAdministrativa::all();
        $classificacoes = Classificacao::all();

        $query = Patrimonio::query();
        
        if ($request->has('busca') && $request->busca != '') {
            $query->where('nome', 'ilike', "%$request->busca%");
        }

        if ($request->has('predio_id')) {
            $query->whereHas('sala', function ($sala) use ($request) {
                $sala->where('predio_id', $request->predio_id);
            });
        }

        if ($request->user()->hasAnyRoles(['Administrador', 'Diretor']) && $request->has('servidor_id')) {
            $query->where('servidor_id', $request->servidor_id);
        } else if ($request->user()->hasAnyRoles(['Servidor'])) {
            $query->where('servidor_id', Auth::user()->servidor->id);
        }

        if ($request->has('situacao_id')) {
            $query->where('situacao_id', $request->situacao_id);
        }

        if ($request->has('origem_id')) {
            $query->where('origem_id', $request->origem_id);
        }

        if ($request->has('unidade_admin_id')) {
            $query->where('unidade_admin_id', $request->unid_admin_id);
        }

        if ($request->has('classificacao_id')) {
            $query->whereHas('subgrupo', function ($subgrupo) use ($request) {
                $subgrupo->where('classificacao_id', $request->classificacao_id);
            });
        }

        $patrimonios = $query->paginate(5);

        return view('patrimonio.index', compact('patrimonios', 'predios', 'servidores', 'situacoes', 'origens', 'unidades', 'classificacoes'));
    }

    public function create()
    {
        $unidades = UnidadeAdministrativa::all();
        $origens = Origem::orderBy('nome')->get();
        $predios = Predio::with('salas')->orderBy('nome')->get();
        $situacoes = Situacao::orderBy('nome')->get();
        $subgrupos = Subgrupo::orderBy('nome')->get();
        $servidores = Servidor::with(['user' => function ($query) {
            $query->orderBy('name');
        }])->get();

        return view('patrimonio.create', compact('unidades', 'origens', 'predios', 'situacoes', 'servidores', 'subgrupos'));
    }

    public function store(StorePatrimonioRequest $request)
    {
        $this->authorize('create', Patrimonio::class);
        $validatedData = $request->validated();

        $patrimonio = Patrimonio::create($validatedData);

        return redirect()->route('patrimonio.codigo.index', ['patrimonio_id' => $patrimonio->id], 201)->with('success', 'Patrimônio Cadastrado com Sucesso, Adicione os Códigos ao Patrimônio.');
    }

    public function edit($patrimonio_id)
    {
        $patrimonio = Patrimonio::find($patrimonio_id);
        $unidades = UnidadeAdministrativa::all();
        $origens = Origem::orderBy('nome')->get();
        $predios = Predio::with('salas')->orderBy('nome')->get();
        $situacoes = Situacao::orderBy('nome')->get();
        $subgrupos = Subgrupo::orderBy('nome')->get();
        $servidores = Servidor::with(['user' => function ($query) {
            $query->orderBy('name');
        }])->get();
        return view('patrimonio.edit', compact('patrimonio', 'unidades', 'origens', 'predios', 'situacoes', 'servidores', 'subgrupos'));
    }

    public function update(UpdatePatrimonioRequest $request, $id)
    {
        $patrimonio = Patrimonio::findOrFail($id);
        $patrimonio->update($request->all()); 
        return redirect(route('patrimonio.index'))->with('success', 'Patrimônio Editado com Sucesso!');
    }


    public function delete($patrimonio_id)
    {
        $patrimonio = Patrimonio::find($patrimonio_id);
        $movimento = MovimentoPatrimonio::where('patrimonio_id', $patrimonio->id)->first();
        if ($movimento == null) {
            $patrimonio->delete();
            return redirect(route('patrimonio.index'))->with('success', 'Patrimonio Removido com Sucesso!');
        } else {
            return redirect(route('patrimonio.index'))->with('fail', 'Não é possivel remover, o patrimônio já foi movimentado.');
        }
    }

    public function getSalas(Request $request)
    {
        $predio_id = json_decode($request->predio_id);
        $salas = Sala::where('predio_id', $predio_id)->get();
        return response()->json($salas);
    }

    
    public function relatorio(Request $request)
    {
        $query = Patrimonio::query();

        if ($request->filled('unidade_admin_id')) {
            $query->where('unidade_admin_id', $request->unidade_admin_id);
        }
        if ($request->filled('situacao_id')) {
            $query->where('situacao_id', $request->situacao_id);
        }
        if ($request->filled('ano')) {
            $ano = $request->ano;
            $query->whereYear('data_compra', $ano);
        }

        $patrimonios = $query->paginate(5);

        $unidades = UnidadeAdministrativa::all();
        $situacoes = Situacao::all();

        return view('patrimonio.relatorio.index', compact('patrimonios', 'unidades', 'situacoes'));
    }
    public function gerarRelatorioPatrimonio($patrimonio_id)
    {
        $patrimonio = Patrimonio::findOrFail($patrimonio_id);

        $movimentos = MovimentoPatrimonio::where('patrimonio_id', $patrimonio->id)->get();

        $pdf = PDF::loadView('pdf.patrimonio_individual', compact('patrimonio', 'movimentos'));

        return $pdf->stream('relatorio_patrimonio_'.$patrimonio->id.'.pdf');
    }

    public function show($id)
    {
        $patrimonio = Patrimonio::findOrFail($id);
        $classificacao = Classificacao::findOrFail($patrimonio->subgrupo->classificacao_id);
        $setores = Setor::all();
        return view('patrimonio.Info', compact('patrimonio', 'classificacao', 'setores'));
    }


    public function codigosPatrimonio($patrimonio_id)
    {
        $patrimonio = Patrimonio::find($patrimonio_id);
        return view('patrimonio.codigo.index_create', compact('patrimonio'));
    }

    public function codigoStore(StoreCodigoPatrimonioRequest $request)
    {
        Codigo::create($request->all());

        return redirect()->route('patrimonio.codigo.index', ['patrimonio_id' => $request->patrimonio_id])->with('success', 'Código Cadastrado com Sucesso!');
    }

    public function codigoDelete($codigo_id)
    {
        $codigo = Codigo::find($codigo_id);
        $patrimonio = Patrimonio::find($codigo->patrimonio_id);
        $codigo->delete();
        return view('patrimonio.codigo.index_create', compact('patrimonio'));
    }
}