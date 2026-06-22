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
        Schema::create('shipping_rates', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('zone_id');
            $table->foreign('zone_id')->references('id')->on('shipping_zones')->onDelete('cascade');
            $table->decimal('cost', 12, 2);
            $table->decimal('minimum_weight', 8, 3)->default(0);
            $table->decimal('maximum_weight', 8, 3)->default(100);
            $table->integer('delivery_time_days')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();

            $table->index('zone_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('shipping_rates');
    }
};
