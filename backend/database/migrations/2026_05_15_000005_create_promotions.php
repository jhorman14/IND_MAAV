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
        Schema::create('promotions', function (Blueprint $table) {
            $table->id();
            $table->string('codigo')->unique();
            $table->string('descripcion')->nullable();
            $table->enum('tipo', ['porcentaje', 'monto_fijo', 'envio_gratis'])->default('porcentaje');
            $table->decimal('valor', 12, 2);
            $table->integer('cantidad_maxima_usos')->nullable();
            $table->integer('cantidad_usos')->default(0);
            $table->integer('usos_por_usuario')->default(1);
            $table->decimal('monto_minimo_compra', 12, 2)->default(0);
            $table->unsignedBigInteger('categoria_id')->nullable();
            $table->foreign('categoria_id')->references('id')->on('categories')->onDelete('set null');
            $table->date('fecha_inicio');
            $table->date('fecha_fin');
            $table->enum('estado', ['activa', 'inactiva', 'expirada'])->default('activa');
            $table->timestamps();

            $table->index('codigo');
            $table->index('estado');
            $table->index('fecha_inicio');
            $table->index('fecha_fin');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotions');
    }
};
