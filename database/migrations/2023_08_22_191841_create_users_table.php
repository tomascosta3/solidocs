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
            
            $table->id();

            $table->string('first_name')->nullable();

            $table->string('last_name')->nullable();

            $table->string('dni', 20)->nullable()->unique();

            $table->string('phone_number')->nullable();

            $table->string('email');

            $table->string('password');

            $table->boolean('verified')->default(false);

            $table->timestamp('verified_at')->nullable();

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};
