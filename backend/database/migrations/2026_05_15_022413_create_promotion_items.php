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
        Schema::create('promotion_items', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('promocion_id');
            $table->foreign('promocion_id')->references('id')->on('promotions')->onDelete('cascade');
            $table->uuid('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->uuid('orden_id')->nullable();
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('set null');
            $table->timestamp('fecha_uso')->useCurrent();

            $table->index('promocion_id');
            $table->index('usuario_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('promotion_items');
    }
};
