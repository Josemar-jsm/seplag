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
        Schema::create('locacao', function (Blueprint $table) {
            $table->id('lot_id');
            $table->integer('pes_id');
            $table->integer('unid_id');
            $table->date('lot_data_lotacao')->nullable();
            $table->date('lot_data_remocao')->nullable();
            $table->string('lot_portaria', 100)->nullable();
            $table->timestamps();

            $table->foreign('pes_id')->references('pes_id')->on('pessoa');
            $table->foreign('unid_id')->references('unid_id')->on('unidade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('locacao');
    }
};
