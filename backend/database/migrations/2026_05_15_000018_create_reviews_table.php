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
        Schema::create('reviews', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('cascade');
            $table->uuid('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            
            $table->integer('calificacion')->unsigned();
            $table->string('titulo')->nullable();
            $table->text('comentario')->nullable();
            
            $table->boolean('compra_verificada')->default(false);
            $table->uuid('orden_id')->nullable();
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->timestamp('created_at')->useCurrent();

            $table->index('producto_id');
            $table->index('usuario_id');
            $table->index('compra_verificada');
            $table->unique(['producto_id', 'usuario_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
