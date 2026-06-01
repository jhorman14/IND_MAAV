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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('nombre');
            $table->string('slug')->unique();
            $table->text('descripcion');
            $table->text('descripcion_detallada')->nullable();
            $table->unsignedBigInteger('categoria_id');
            $table->foreign('categoria_id')->references('id')->on('categories')->onDelete('cascade');
            $table->string('marca')->nullable();
            $table->string('sku')->unique();
            $table->decimal('precio', 12, 2);
            $table->decimal('precio_original', 12, 2)->nullable();
            $table->integer('cantidad_disponible')->default(0);
            $table->integer('cantidad_minima_compra')->default(1);
            $table->decimal('calificacion_promedio', 3, 2)->default(0);
            $table->integer('numero_resenas')->default(0);
            $table->enum('estado', ['activo', 'inactivo', 'descontinuado'])->default('activo');
            $table->boolean('visible_publico')->default(true);
            $table->decimal('peso_kg', 8, 3)->nullable();
            $table->integer('dimensiones_ancho_mm')->nullable();
            $table->integer('dimensiones_profundidad_mm')->nullable();
            $table->integer('dimensiones_alto_mm')->nullable();
            $table->string('material')->nullable();
            $table->string('acabado')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('slug');
            $table->index('categoria_id');
            $table->index('sku');
            $table->index('estado');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
