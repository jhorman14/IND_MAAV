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
        Schema::create('payments', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->string('customer_email');
            $table->decimal('amount', 12, 2);
            $table->string('currency')->default('COP');
            $table->enum('status', ['pending', 'approved', 'rejected', 'cancelled', 'refunded'])->default('pending');
            $table->string('payment_method')->nullable();
            $table->string('external_reference')->nullable();
            $table->string('mercadopago_reference')->nullable();
            $table->string('last_four')->nullable();
            $table->string('bank')->nullable();
            $table->timestamp('paid_at')->nullable();
            $table->timestamp('reconciled_at')->nullable();
            $table->text('error_note')->nullable();
            $table->timestamps();

            $table->index('order_id');
            $table->index('status');
            $table->index('customer_email');
            $table->index('mercadopago_reference');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('payments');
    }
};
