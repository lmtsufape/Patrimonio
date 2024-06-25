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
        Schema::create('sala_unidade_administrativa', function (Blueprint $table) {
            $table->id();
            $table->foreignId('sala_id')->constrained();
            $table->foreignId('unidade_admin_id')->constrained('unidades_administrativas');
            
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
        Schema::dropIfExists('sala_unidade_administrativa');
    }
};
