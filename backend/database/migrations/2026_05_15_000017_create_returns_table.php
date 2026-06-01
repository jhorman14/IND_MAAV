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
        Schema::create('returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('orden_id');
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('cascade');
            $table->uuid('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('restrict');
            
            $table->string('motivo');
            $table->text('descripcion')->nullable();
            $table->enum('estado', ['solicitada', 'aprobada', 'rechazada', 'recibida', 'procesada'])->default('solicitada');
            
            $table->timestamp('fecha_solicitud')->useCurrent();
            $table->timestamp('fecha_recepcion')->nullable();
            $table->timestamp('fecha_procesamiento')->nullable();
            
            $table->decimal('monto_reembolso', 12, 2)->nullable();
            $table->text('notas_admin')->nullable();
            
            $table->timestamps();

            $table->index('orden_id');
            $table->index('usuario_id');
            $table->index('estado');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
