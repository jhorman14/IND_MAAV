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
        Schema::create('user_addresses', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->enum('tipo', ['envio', 'facturacion', 'otro'])->default('envio');
            $table->string('nombre_direccion')->nullable();
            $table->string('direccion');
            $table->string('ciudad');
            $table->string('departamento');
            $table->string('codigo_postal')->nullable();
            $table->string('pais')->default('Colombia');
            $table->boolean('es_default')->default(false);
            $table->text('notas')->nullable();
            $table->timestamps();

            $table->index('usuario_id');
            $table->index('tipo');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_addresses');
    }
};
