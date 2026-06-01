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
        Schema::create('orders', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('numero_orden')->unique();
            $table->uuid('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('restrict');
            
            // Información del cliente (para notificaciones y auditoría)
            $table->string('nombre_cliente');
            $table->string('email_cliente');
            
            $table->enum('estado', ['pendiente_pago', 'pagado', 'preparando', 'enviado', 'entregado', 'cancelado', 'reembolsado'])->default('pendiente_pago');
            $table->decimal('subtotal', 12, 2);
            $table->decimal('impuesto_iva', 12, 2);
            $table->decimal('descuento', 12, 2)->default(0);
            $table->decimal('costo_envio', 12, 2);
            $table->decimal('total', 12, 2);
            
            // Dirección de envío
            $table->string('direccion_envio', 500);
            $table->string('ciudad_envio');
            $table->string('departamento_envio');
            $table->string('codigo_postal_envio')->nullable();
            
            // Dirección de facturación
            $table->string('direccion_facturacion', 500)->nullable();
            $table->string('ciudad_facturacion')->nullable();
            $table->string('departamento_facturacion')->nullable();
            
            $table->string('telefono_contacto')->nullable();
            $table->enum('tipo_envio', ['express', 'estandar'])->default('estandar');
            $table->string('metodo_pago')->nullable();
            $table->text('notas')->nullable();
            $table->timestamp('fecha_envio')->nullable();
            $table->timestamp('fecha_entrega')->nullable();
            $table->timestamps();

            $table->index('numero_orden');
            $table->index('usuario_id');
            $table->index('estado');
            $table->index('email_cliente');
            $table->index('created_at');
            $table->index('fecha_envio');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
