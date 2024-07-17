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
        Schema::create('movimentos', function (Blueprint $table) {
            $table->id();
            $table->tinyInteger('tipo');
            $table->string('status')->default('Pendente');//aprovada/reprovada -> entregue -> finalizada
            $table->date('data');
            $table->string('cidade')->nullable();
            $table->string('logradouro')->nullable();
            $table->string('numero')->nullable();
            $table->string('bairro')->nullable();
            $table->string('evento')->nullable();
            $table->date('data_devolucao')->nullable();
            $table->string('motivo')->nullable();

            $table->foreignId('sala_id')->nullable()->constrained();
            $table->foreignId('user_origem_id')->constrained('users');
            $table->foreignId('user_destino_id')->nullable()->constrained('users');

            $table->softDeletes();
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
        Schema::dropIfExists('movimentos');
    }
};
