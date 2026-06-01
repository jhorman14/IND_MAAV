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
        Schema::create('order_state_history', function (Blueprint $table) {
            $table->id();
            $table->uuid('orden_id');
            $table->foreign('orden_id')->references('id')->on('orders')->onDelete('cascade');
            
            $table->string('estado_anterior')->nullable();
            $table->string('estado_nuevo');
            
            $table->uuid('usuario_id')->nullable();
            $table->foreign('usuario_id')->references('id')->on('users')->onDelete('set null');
            
            $table->text('comentario')->nullable();
            $table->timestamp('created_at')->useCurrent();

            $table->index('orden_id');
            $table->index('usuario_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_state_history');
    }
};
