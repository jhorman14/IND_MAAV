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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zona_id');
            $table->foreign('zona_id')->references('id')->on('shipping_zones')->onDelete('cascade');
            $table->enum('tipo_envio', ['express', 'estandar'])->default('estandar');
            $table->decimal('costo_base', 12, 2);
            $table->decimal('costo_por_kg', 12, 2)->default(0);
            $table->integer('dias_entrega')->nullable();
            $table->decimal('peso_maximo_kg', 8, 3)->default(100);
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->timestamps();

            $table->index('zona_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
