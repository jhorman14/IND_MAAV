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
        Schema::create('inventory_movements', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('product_id');
            $table->foreign('product_id')->references('id')->on('products')->onDelete('restrict');

            $table->integer('previous_quantity');
            $table->integer('new_quantity');
            $table->integer('moved_quantity');

            $table->enum('reason', ['purchase', 'return', 'manual_adjustment', 'loss', 'stock_entry'])->default('manual_adjustment');
            $table->string('reference_id')->nullable();
            $table->string('reference_type')->nullable();

            $table->uuid('user_id')->nullable();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('set null');

            $table->text('notes')->nullable();
            $table->timestamps();

            $table->index('product_id');
            $table->index('reason');
            $table->index('reference_id');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('inventory_movements');
    }
};
