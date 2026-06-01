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
        Schema::create('product_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('producto_id');
            $table->foreign('producto_id')->references('id')->on('products')->onDelete('cascade');
            $table->string('url', 500);
            $table->boolean('es_principal')->default(false);
            $table->integer('orden')->default(0);
            $table->string('alt_text', 255)->nullable();
            $table->timestamps();

            $table->index('producto_id');
            $table->index('es_principal');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_images');
    }
};
