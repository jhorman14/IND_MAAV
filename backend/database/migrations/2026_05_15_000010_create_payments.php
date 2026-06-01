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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('orden_id');
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('email_cliente');
            $table->decimal('monto', 12, 2);
            $table->string('moneda')->default('COP');
            $table->enum('estado', ['pendiente', 'aprobado', 'rechazado', 'cancelado', 'reembolsado'])->default('pendiente');
            $table->string('metodo_pago')->nullable();
            $table->string('referencia_externo')->nullable();
            $table->string('referencia_mercadopago')->nullable();
            $table->string('tipo_pago')->nullable();
            $table->string('ultimos_4_digitos')->nullable();
            $table->string('banco')->nullable();
            $table->timestamp('fecha_pago')->nullable();
            $table->timestamp('fecha_conciliacion')->nullable();
            $table->text('nota_error')->nullable();
            $table->timestamps();

            $table->index('orden_id');
            $table->index('estado');
            $table->index('email_cliente');
            $table->index('referencia_mercadopago');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
