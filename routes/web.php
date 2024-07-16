<?php

use App\Http\Controllers\SubgrupoController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\HomeController;
use App\Http\Controllers\PredioController;
use App\Http\Controllers\SalaController;
use App\Http\Controllers\CargoController;
use App\Http\Controllers\ClassificacaoController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\UnidadeAdministrativaController;
use App\Http\Controllers\PatrimonioController;
use App\Http\Controllers\MovimentoController;
use App\Models\UnidadeAdministrativa;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Auth::routes();

Route::get('/validate', [HomeController::class, 'invalid'])->middleware('valid:false')->name('invalid');

Route::middleware(['auth', 'valid:true'])->group(function () {
    Route::controller(HomeController::class)->group(function () {
        Route::get('/', 'home')->name('home');
    });

    Route::prefix('subgrupo')->name('subgrupo.')->controller(SubgrupoController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{subgrupo_id}/editar', 'edit')->name('edit');
        Route::put('/{subgrupo_id}/update', 'update')->name('update');
        Route::delete('/{subgrupo_id}/delete', 'delete')->name('delete');
        Route::get('/search', 'search')->name('buscar');
    });

    Route::prefix('predio')->name('predio.')->controller(PredioController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{predio_id}/editar', 'edit')->name('edit');
        Route::put('/{id}/update', 'update')->name('update');
        Route::delete('/{predio_id}/delete', 'delete')->name('delete');
        Route::get('/predio/busca', 'busca')->name('busca.get');
    });

    Route::prefix('predio')->name('sala.')->controller(SalaController::class)->group(function () {
        Route::get('/{predio_id}/sala/listar', 'index')->name('index');
        Route::get('/{predio_id}/sala/cadastrar', 'create')->name('create');
        Route::post('/sala/store', 'store')->name('store');
        Route::get('/sala/{sala_id}/editar', 'edit')->name('edit');
        Route::put('/sala/{sala_id}/update', 'update')->name('update');
        Route::delete('/sala/{sala_id}/delete', 'delete')->name('delete');
    });

    Route::get('/salas/search', [SalaController::class, 'search'])->name('sala.buscar');

    Route::prefix('cargo')->name('cargo.')->controller(CargoController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{cargo_id}/editar', 'edit')->name('edit');
        Route::put('/{cargo_id}/update', 'update')->name('update');
        Route::delete('/{cargo_id}/delete', 'delete')->name('delete');
        Route::get('/search', 'search')->name('buscar');
    });

    Route::prefix('classificacao')->name('classificacao.')->controller(ClassificacaoController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{classificacao_id}/editar', 'edit')->name('edit');
        Route::put('/update/{classificacao_id}', 'update')->name('update');
        Route::delete('/{classificacao_id}/delete', 'delete')->name('delete');
        Route::get('/search', 'search')->name('buscar');
    });

    Route::prefix('servidor')->name('servidor.')->controller(UserController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{id}/editar', 'edit')->name('edit');
        Route::put('/{id}/update', 'update')->name('update');
        Route::get('/{id}/delete', 'delete')->name('delete');
        Route::get('/{id}/validar', 'validar')->name('validar')->middleware('check-role:Administrador,Diretor');
        Route::get('/search', 'search')->name('buscar');
    });

    Route::prefix('unidade')->name('unidade.')->controller(UnidadeAdministrativaController::class)->group(function () {
        Route::get('/listar/{unidade_admin_pai_id?}', 'index')->name('index');
        Route::get('/cadastrar/{unidade_admin_pai_id?}', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{unidade_admin_id}/editar', 'edit')->name('edit');
        Route::put('/update/{unidade_admin_id}', 'update')->name('update');
        Route::delete('/{unidade_admin_id}/delete', 'delete')->name('delete');
        Route::get('/search', 'search')->name('buscar');
        // Route::get('/{setor_id}/restore', [SetorController::class, 'restore'])->name('restore');
    });

    Route::prefix('patrimonio')->name('patrimonio.')->controller(PatrimonioController::class)->group(function () {
        Route::get('/listar', 'index')->name('index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{patrimonio_id}/editar', 'edit')->name('edit');
        Route::put('/update/{id}', 'update')->name('update');
        Route::get('/{patrimonio_id}/delete', 'delete')->name('delete');
        Route::get('/{patrimonio_id}/restore', 'restore')->name('restore');
        Route::get('/{patrimonio_id}/codigos', 'codigosPatrimonio')->name('codigo.index');
        Route::get('/codigos/{codigo_id}/delete', 'codigoDelete')->name('codigo.delete');
        Route::post('/codigo/store', 'codigoStore')->name('codigo.store');
        Route::get('/getSalas', 'getSalas')->name('getSalas');
        Route::get('/relatorio-pdf/{id}', 'gerarRelatorioPatrimonio')->name('relatorio.pdf');
        Route::get('/relatorio', 'relatorio')->name('relatorio.index');
        Route::get('/patrimonio/{patrimonio_id}', 'show')->name('patrimonio');

    });

    Route::prefix('movimento')->name('movimento.')->controller(MovimentoController::class)->group(function () {
        Route::get('/finalizar/{movimento_id}', 'finalizarMovimentacao')->name('finalizar');
        Route::get('/listar', 'index')->name('index');
        Route::get('/aprovar/{movimento_id}', 'aprovarMovimentacao')->name('aprovar');
        Route::get('/reprovar/{movimento_id}', 'reprovarMovimentacao')->name('reprovar');
        Route::get('/listar/pedidos', 'indexPedidosMovimentos')->name('pedidos.index');
        Route::get('/cadastrar', 'create')->name('create');
        Route::post('/store', 'store')->name('store');
        Route::get('/{movimento_id}/editar', 'edit')->name('edit');
        Route::post('/update', 'update')->name('update');
        Route::delete('/{movimento_id}/delete', 'delete')->name('delete');
        Route::get('/{movimento_id}/restore', 'restore')->name('restore');
        Route::post('/store/patrimonio', 'adicionarPatrimonio')->name('patrimonio.store');
        Route::post('/concluir', 'concluirMovimentacao')->name('concluir');
        Route::get('/{movimento_id}/detalhamento', 'detalhamento')->name('detalhamento');
        Route::get('/delete/patrimonio/{movimento_id}', 'removerPatrimonio')->name('patrimonio.delete');
        Route::get('/search', 'search')->name('buscar');
    });
    Route::get('/buscar-salas/{user_id}', [MovimentoController::class, 'buscarSalas'])->name('salas.buscar');
});
