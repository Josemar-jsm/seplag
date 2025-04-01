<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('endereco', function (Blueprint $table) {
            $table->id('end_id');
            $table->string('end_tipo_logradouro', 50)->nullable();
            $table->string('end_logradouro', 200)->nullable();
            $table->integer('end_numero')->nullable();
            $table->string('end_bairro', 100)->nullable();
            $table->integer('cid_id')->nullable();
            $table->timestamps();

            $table->foreign('cid_id')->references('cid_id')->on('cidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('endereco');
    }
};
