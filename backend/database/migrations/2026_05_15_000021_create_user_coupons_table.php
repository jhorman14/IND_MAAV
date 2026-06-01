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
        Schema::create('user_coupons', function (Blueprint $table) {
            $table->id();
            $table->uuid('usuario_id');
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('cascade');
            $table->unsignedBigInteger('promocion_id');
            $table->foreign('promocion_id')->references('id')->on('promotions')->onDelete('cascade');
            
            $table->boolean('usado')->default(false);
            $table->timestamp('fecha_uso')->nullable();
            
            $table->uuid('orden_id')->nullable();
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('set null');
            
            $table->timestamp('created_at')->useCurrent();

            $table->unique(['usuario_id', 'promocion_id']);
            $table->index('usuario_id');
            $table->index('promocion_id');
            $table->index('usado');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_coupons');
    }
};
