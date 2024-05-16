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
        Schema::create('cargo_user', function (Blueprint $table) {
            $table->id();
            
            $table->foreignId('cargo_id')->constrained()->restrictOnDelete();
            $table->foreignId('user_id')->constrained();

            $table->unique(['cargo_id', 'user_id']);
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
        Schema::dropIfExists('cargo_user');
    }
};
