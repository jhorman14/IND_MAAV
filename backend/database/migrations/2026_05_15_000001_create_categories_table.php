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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            $table->string('nombre')->unique();
            $table->string('slug')->unique();
            $table->text('descripcion')->nullable();
            $table->string('icono')->nullable();
            $table->string('imagen')->nullable();
            $table->unsignedBigInteger('categoria_padre_id')->nullable();
            $table->foreign('categoria_padre_id')->references('id')->on('categories')->onDelete('cascade');
            $table->integer('orden')->default(0);
            $table->enum('estado', ['activa', 'inactiva'])->default('activa');
            $table->timestamps();

            $table->index('slug');
            $table->index('categoria_padre_id');
            $table->index('orden');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }
};
