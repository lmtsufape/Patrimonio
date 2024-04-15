<?php

namespace App\Http\Controllers;

use App\Http\Requests\Servidor\StoreServidorRequest;
use App\Http\Requests\Servidor\UpdateServidorRequest;
use App\Models\Cargo;
use App\Models\Role;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    public function index()
    {
        $servidores = User::OrderBy('id')->paginate(5);
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
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        
        $user->roles()->sync($request->role_id);

        User::create([
            'user_id' => $user->id,
            'cpf' => $request->cpf,
            'matricula' => $request->matricula,
        ]);

        return redirect()->route('servidor.index')->with('success', 'Servidor Cadastrado com Sucesso!');
    }

    public function edit($user_id)
    {
        $servidor = User::withTrashed()->find($user_id);
        $cargos = Cargo::all();
        $roles = Role::all();
        return view('servidor.edit', compact('servidor', 'cargos', 'roles'));
    }

    public function update(UpdateServidorRequest $request)
    {
        $servidor = User::withTrashed()->find($request->servidor_id);
        $user = $servidor->user;

        if ($request->password != null) {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);
            $user->roles()->sync($request->role_id);

        } else {
            $user->update([
                'name' => $request->name,
                'email' => $request->email,
                'password' => $user->password
            ]);
            $user->roles()->sync($request->role_id);

        }

        $servidor->update([
            'cpf' => $request->cpf,
            'matricula' => $request->matricula,
            'cargo_id' => $request->cargo_id
        ]);
        return redirect(route('servidor.index'))->with('success', 'Servidor Editado com Sucesso!');
    }

    public function delete($user_id)
    {
        $servidor = User::find($user_id);
        $user = $servidor->user;
        $user->delete();
        return redirect(route('servidor.index'))->with('success', 'Servidor Desativado com Sucesso!');
    }

    public function validar($id)
    {
        $user = User::findOrFail($id);
        $user->update(['ativo' => !$user->ativo]);

        return redirect()->back()->with(['success' => 'Servidor alterado']);
    }

    public function search(Request $request)
    {
        $servidores = User::whereHas('user', function ($query) use ($request) {
            $query->where('name', 'ilike', "%$request->busca%");
        })->paginate(10);
        $cargos = Cargo::all();
        $roles = Role::where('nome', '<>', 'Administrador')->get();

        return view('servidor.index', compact('servidores', 'cargos', 'roles'));
    }
}
