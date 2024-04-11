<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('patrimonios', function (Blueprint $table) {
            $table->id();
            $table->string('nome');
            $table->string('nota_fiscal')->nullable(); //VerificarDepois
            $table->string('descricao');
            $table->boolean('aprovado')->default(true);
            $table->text('observacao')->nullable();
            $table->date('data_compra')->nullable();
            $table->date('data_incorporação')->nullable();
            $table->double('valor');
            $table->string('empenho');
            $table->string('conta_contabil');

            $table->foreignId('user_id')->constrained();
            $table->foreignId('unidade_admin_id')->constrained('unidades_administrativas')->nullable();
            $table->foreignId('subgrupo_id')->constrained('subgrupos');
            $table->foreignId('origem_id')->constrained('origens');
            $table->foreignId('sala_id')->constrained();
            $table->foreignId('situacao_id')->constrained('situacoes');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('patrimonios');
    }
};
