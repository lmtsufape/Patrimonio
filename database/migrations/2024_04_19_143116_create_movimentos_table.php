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
            $table->date('data');
            $table->string('status')->default('Pendente');//aprovada/reprovada -> entregue -> finalizada
            $table->string('motivo')->nullable();

            $table->foreignId('patrimonio_id')->constrained();
            $table->foreignId('sala_id')->constrained();
            $table->foreignId('user_origem_id')->constrained('users');
            $table->foreignId('user_destino_id')->constrained('users')->nullable();

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
