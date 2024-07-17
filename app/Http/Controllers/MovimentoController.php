<?php

namespace App\Http\Controllers;

use App\Http\Requests\Movimento\ConcluirMovimentoRequest;
use App\Http\Requests\Movimento\StoreMovimentoRequest;
use App\Http\Requests\Movimento\UpdateMovimentoRequest;
use App\Mail\CriacaoMovimentoMail;
use App\Models\Movimento;
use App\Models\MovimentoPatrimonio;
use App\Models\Patrimonio;
use App\Models\Predio;
use App\Models\User;
use App\Models\TipoMovimento;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class MovimentoController extends Controller
{
    public function index()
    {
        if(Auth::user()->hasAnyRoles(['Administrador'])){
            $movimentos = Movimento::paginate(10);
        }
        if(Auth::user()->hasAnyRoles(['Servidor'])){
            $movimentos = Movimento::where('user_origem_id', Auth::user()->id)->paginate(10);
        }

        return view('movimento.index', compact('movimentos'));
    }

    public function indexPedidosMovimentos()
    {
        if(Auth::user()->hasAnyRoles(['Administrador'])){
            $movimentos = Movimento::where('status', 'Aprovado')->orWhere('user_destino_id', Auth::user()->id)->paginate(10);
            
            return view('movimento.index_pedidos', compact('movimentos'));
        }
        $movimentos = Movimento::where('user_destino_id', Auth::user()->id)->paginate(10);

        return view('movimento.index_pedidos', compact('movimentos'));

    }

    public function create()
    {
        $servidores = User::where('id', '!=', Auth::user()->id)->get();
        $patrimonios = Patrimonio::where('user_id', Auth::user()->id)->whereNotIn('id',function($query){
            $query->select('patrimonio_id')->from('movimento_patrimonio');
        })->with('sala.predio')->get();

        $patrimoniosDisponi = Patrimonio::whereIn('sala_id', [21, 22])->get();

        return view('movimento.create', compact( 'servidores', 'patrimonios', 'patrimoniosDisponi'));
    }

    public function store(StoreMovimentoRequest $request)
    {
        $data = $request->all();
        switch ($request->tipo) {
            case 1://Solicitação
                $data['user_origem_id'] = Auth::user()->id;
                $data['sala_id'] = $request->sala_id;
                if(Auth::user()->hasAnyRoles(['Administrador'])){
                    $data['status'] = 'Finalizado';
                }else{
                    $data['status'] = 'Aprovado';
                };

                break;
            case 2://Emprestimo
                $data['user_origem_id'] = Auth::user()->id;
                $data['cidade'] = $request->cidade;
                $data['logradouro'] = $request->logradouro;
                $data['numero'] = $request->numero;
                $data['bairro'] = $request->bairro;
                $data['evento'] = $request->evento;
                $data['data_devolucao'] = $request->data_devolucao;
                if(Auth::user()->hasAnyRoles(['Administrador'])){
                    $data['status'] = 'Finalizado';
                }else{
                    $data['status'] = 'Aprovado';
                };
                break;
            case 3://Devolução
                $data['user_origem_id'] = Auth::user()->id;
                $data['user_destino_id'] = User::where(function($query) {
                                            $query->whereHas('roles', function($roleQuery) {
                                                    $roleQuery->whereIn('nome', ['Administrador']);
                                                })->whereHas('cargos', function($cargoQuery) {
                                                    $cargoQuery->whereIn('nome', ['Diretor']);
                                                });
                                            })->pluck('id')->first();
                $data['motivo'] = $request->motivo;
                if(Auth::user()->hasAnyRoles(['Administrador'])){
                    $data['status'] = 'Finalizado';
                }else{
                    $data['status'] = 'Aprovado';
                };
                $data['cargo_id'] = 3;
                $data['sala_id'] = 1;

                break;
            case 4://Transferência
                $data['user_origem_id'] = Auth::user()->id;
                $data['user_destino_id'] = $request->user_destino_id;
                $data['sala_id'] = $request->sala_id;
                break;
        }

        $data['data'] = now();
        $movimento = Movimento::create($data);
        $movimento->patrimonios()->attach(array_map('intval',(explode(',', (implode(',', $request->patrimonios_id))))));
        if($request->tipo == 4){//Tranferência
            Mail::to($movimento->userDestino->email)->send(new CriacaoMovimentoMail($movimento));
        }

        return redirect()->route('movimento.index')->with('success', 'Movimento Cadastrado com Sucesso!');
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

        if($movimento->status == 'Aprovado' || $movimento->status == 'Finalizado')
            return redirect()->route('movimento.index')->with('fail', 'Não é possivel editar um movimento já concluído!');

        $movimento->update($data);
        return redirect()->route('movimento.edit', ['movimento_id' => $movimento->id])->with('success', 'Movimento Alterado com Sucesso!');
    }

    public function delete($movimento_id)
    {
        $movimento = Movimento::find($movimento_id);
        if($movimento->status == 'Pendente'){
            $movimento->patrimonios()->detach();
            $movimento->forceDelete();
            return redirect()->route('movimento.index')->with('success', 'Movimento removido com sucesso!');
        }

        return redirect()->route('movimento.index')->with('fail', 'O movimento já foi concluído e não pode ser excluído.');
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

    public function finalizarMovimentacao($movimento_id){
        $movimento = Movimento::find($movimento_id);
        $movimento->patrimonios()->update([
            'user_id'   => $movimento->user_destino_id,
            'sala_id'   => $movimento->sala_id,
            'unidade_admin_id'  => $movimento->user_destino_id,
        ]);

        $movimento->status = 'Finalizado';
        $movimento->update();

        return redirect()->back();
    }

    public function aprovarMovimentacao($movimento_id){

        $movimento = Movimento::find($movimento_id);
        $movimento->status = 'Aprovado';
        $movimento->update();

        return redirect()->back();
    }

    public function reprovarMovimentacao($movimento_id){

        $movimento = Movimento::find($movimento_id);
        $movimento->status = 'Reprovado';
        $movimento->update();

        return redirect()->back();

    }

    public function detalhamento($movimento_id){
        $movimento = Movimento::find($movimento_id);

        return view('movimento.detalhamento', compact('movimento'));
    }

    public function buscarSalas($user_id){
    $user = User::find($user_id);

    if (!$user) {
        return response()->json(['error' => 'Servidor não encontrado'], 404);
    }

    $salas = $user->salas()->get();

    return response()->json($salas);
}
}
