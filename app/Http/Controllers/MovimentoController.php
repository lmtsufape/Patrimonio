<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movimento\ConcluirMovimentoRequest;
use App\Http\Requests\Movimento\StoreMovimentoRequest;
use App\Http\Requests\Movimento\UpdateMovimentoRequest;
use App\Models\Movimento;
use App\Models\MovimentoPatrimonio;
use App\Models\Patrimonio;
use App\Models\Predio;
use App\Models\User;
use App\Models\TipoMovimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MovimentoController extends Controller
{
    public function index()
    {   
        if(Auth::user()->hasAnyRoles(['Administrador'])){
            $movimentos = Movimento::paginate(10);
        }
        if(Auth::user()->hasAnyRoles(['Servidor'])){
            $movimentos = Movimento::where('user_origem_id', Auth::user()->id)->paginate(10);
            $pedidosMovimentos = Movimento::where('user_destino_id', Auth::user()->id)->paginate(10);
            if(Auth::user()->hasAnyCargos(['Diretor', 'Coordenador'])){

            }
        }

        return view('movimento.index', compact('movimentos'));
    }

    public function create()
    {
        $servidores = User::where('id', '!=', Auth::user()->id)->get();
        $patrimonios = Patrimonio::where('user_id', Auth::user()->id)->whereNotIn('id',function($query){
            $query->select('patrimonio_id')->from('movimentos');
        })->get();
        
        $patrimoniosDisponi = Patrimonio::whereIn('sala_id', [21, 22])->get();

        return view('movimento.create', compact( 'servidores', 'patrimonios', 'patrimoniosDisponi'));
    }

    public function store(StoreMovimentoRequest $request)
    {

        $data = $request->all();
        $data['data_movimento'] = now();

        switch ($request->tipo) {
            case 1://Solicitação
                $data['user_origem_id'] = Auth::user()->id;
                $data['user_destino_id'] = 1;
                break;
            case 2://Emprestimo

                break;
            case 3://Devolução
                $data['user_origem_id'] = Auth::user()->id;
                $data['user_destino_id'] = 1;
                $data['motivo'] = $request->motivo;
                $data['cargo_id'] = 1;
                break;
            case 4://Transferência
                $data['user_origem_id'] = Auth::user()->id;
                $data['user_destino_id'] = $request->user_destino_id;
                $data['cargo_id'] = 1;
                break;        
        }

        $movimento = Movimento::create($data);
        
        return redirect()->back()->with('success', 'Movimento Cadastrado com Sucesso!');
    }

    public function finalizarMovimentacao($movimento_id){
        $movimento = Movimento::find($movimento_id);
        $movimento->patrimonio()->update([
            'user_id'   => $movimento->user_destino_id,
            'sala_id'   => $movimento->user_destino_id->sala()->id,
            'unidade_admin_id'  => $movimento->user_destino_id->unid_admi()->id,
        ]);

        $movimento->status = 'Finalizado';

        return redirect()->back();
    }
    
    public function aprovarMovimentacao($movimento_id){
        $movimento = Movimento::find($movimento_id);
        $movimento->status = 'Aprovado';

    }
    public function reprovarMovimentacao($movimento_id){
        $movimento = Movimento::find($movimento_id);
        $movimento->status = 'Reprovado';

    }
    public function edit($movimento_id)
    {
        $movimento = Movimento::find($movimento_id);
        $servidores = User::where('id', '!=', Auth::user()->id)->get();
        $patrimonios = Patrimonio::where('user_id', Auth::user()->id)->get();
        $patrimoniosDisponi = Patrimonio::whereIn('sala_id', [21, 22])->get();

        return view('movimento.edit', compact('servidores', 'patrimonios', 'patrimoniosDisponi', 'movimento'));
    }

    public function update(UpdateMovimentoRequest $request)
    {
        $data = $request->all();
        $movimento = Movimento::find($data['movimento_id']);

        if($movimento->status == 'Concluido')
            return redirect()->route('movimento.index')->with('fail', 'Não é possivel editar um movimento já concluido!');

        $movimento->update($data);
        return redirect()->route('movimento.edit', ['movimento_id' => $movimento->id])->with('success', 'Movimento Alterado com Sucesso!');
    }

    public function delete($movimento_id)
    {
        $movimento = Movimento::find($movimento_id);
        if($movimento->status == 'Pendente'){
            $movimento->delete();
            return redirect()->route('movimento.index')->with('success', 'Movimento removido com sucesso!');
        }

        return redirect()->route('movimento.index')->with('fail', 'O movimento já foi concluido e não pode ser excluido');


    }

    public function search(Request $request)
    {
        $movimentos = Movimento::whereHas('userOrigem', function ($query) use ($request) {
            $query->where('name', 'ilike', "%$request->busca%");
        })
        ->orWhereHas('userDestino', function ($query) use ($request) {
            $query->where('name', 'ilike', "%$request->busca%");
        })
        ->paginate(10);

        return view('movimento.index', compact('movimentos'));
    }
}
