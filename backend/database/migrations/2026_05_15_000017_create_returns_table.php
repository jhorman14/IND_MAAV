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
        Schema::create('returns', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('order_id');
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('cascade');
            $table->uuid('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('restrict');

            $table->string('reason');
            $table->text('description')->nullable();
            $table->enum('status', ['requested', 'approved', 'rejected', 'received', 'processed'])->default('requested');

            $table->timestamp('requested_at')->useCurrent();
            $table->timestamp('received_at')->nullable();
            $table->timestamp('processed_at')->nullable();

            $table->decimal('refund_amount', 12, 2)->nullable();
            $table->text('admin_notes')->nullable();

            $table->timestamps();

            $table->index('order_id');
            $table->index('user_id');
            $table->index('status');
            $table->index('created_at');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('returns');
    }
};
