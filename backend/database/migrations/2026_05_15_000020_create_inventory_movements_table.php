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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('restrict');
            
            $table->integer('cantidad_anterior');
            $table->integer('cantidad_nueva');
            $table->integer('cantidad_movida');
            
            $table->enum('motivo', ['compra', 'devolucion', 'ajuste_manual', 'perdida', 'entrada_inventario'])->default('ajuste_manual');
            $table->string('referencia_id')->nullable();
            $table->string('referencia_tipo')->nullable();
            
            $table->uuid('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            
            $table->text('notas')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('producto_id');
            $table->index('motivo');
            $table->index('referencia_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
