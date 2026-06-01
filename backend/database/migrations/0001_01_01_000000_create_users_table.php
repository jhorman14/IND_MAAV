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
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('nombre');
            $table->string('email')->unique();
            $table->string('password_hash');
            $table->string('telefono')->nullable();
            $table->string('movil')->nullable();
            $table->string('ubicacion_fisica')->nullable();
            $table->enum('rol', ['customer', 'admin', 'vendor'])->default('customer');
            $table->enum('estado', ['activo', 'inactivo', 'bloqueado'])->default('activo');
            $table->boolean('email_verificado')->default(false);
            $table->timestamp('email_verificado_en')->nullable();
            $table->timestamp('ultimo_login')->nullable();
            $table->string('token_reset_password')->nullable();
            $table->timestamp('token_reset_expira')->nullable();
            $table->timestamps();
            $table->softDeletes();

            $table->index('email');
            $table->index('rol');
            $table->index('estado');
            $table->index('created_at');
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->primary();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->uuid('user_id')->nullable()->index();
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('users');
    }
};
