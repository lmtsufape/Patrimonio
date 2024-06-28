<?php

namespace App\Http\Controllers;

use App\Http\Requests\Servidor\StoreServidorRequest;
use App\Http\Requests\Servidor\UpdateServidorRequest;
use App\Models\Cargo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $servidores = User::OrderBy('id')->paginate(10);
        $cargos = Cargo::all();
        $roles = Role::where('nome', '<>', 'Administrador')->get();
        return view('servidor.index', compact('servidores', 'cargos', 'roles'));
    }

    public function create()
    {
        $cargos = Cargo::all();
        $roles = Role::all();

        return view('servidor.create', compact('cargos', 'roles'));
    }

    public function store(StoreServidorRequest $request)
    {
        $user = User::make($request->except('password'));
        $user->password = Hash::make($request->password);
        $user->save();

        return redirect()->route('servidor.index')->with('success', 'Servidor Cadastrado com Sucesso!');

    }

    public function edit($id)
    {
        $servidor = User::with('roles', 'cargos')->findOrFail($id);
        $cargos = Cargo::all();
        $roles = Role::all();

        return view('servidor.edit', compact('servidor', 'cargos', 'roles'));
    }

    public function update(UpdateServidorRequest $request, $id)
    {

        $user = User::findOrFail($id);
        $validatedData = $request->validated();


        $user->update($validatedData);
        $user->roles()->sync($request->role_id);
        $user->cargos()->sync($request->cargo_id);

        return redirect()->route('servidor.index')->with('success', 'Servidor editado com Sucesso!');
    }

    public function delete($id)
    {
        try {
            User::findOrFail($id)->delete();
        } catch (QueryException $e) {
            if ($e->getCode() == '23503') {
                return redirect()->back()->with(['fail' => 'O servidor não pôde ser deletado.']);
            }
        }

        return redirect()->route('servidor.index')->with('success', 'Servidor deletado com Sucesso!');
    }

    public function validar($id)
    {
        $user = User::findOrFail($id);
        $user->update(['ativo' => !$user->ativo]);

        return redirect()->back()->with(['success' => 'Servidor alterado.']);
    }

    public function search(Request $request)
    {
        $servidores = User::where('name', 'ilike', "%$request->busca%")->paginate(10);
        $cargos = Cargo::all();
        $roles = Role::where('nome', '<>', 'Administrador')->get();

        return view('servidor.index', compact('servidores', 'cargos', 'roles'));
    }
}
