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
        Schema::create('logins', function (Blueprint $table) {
            
            $table->id();

            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');

            $table->string('password');
            
            $table->boolean('verified')->default(false);
            
            $table->string('verification_code')->nullable();

            $table->timestamp('verification_date')->nullable();
            
            $table->timestamp('verification_code_issue_date')->nullable();
            
            $table->timestamp('verification_code_expiration_date')->nullable();

            $table->boolean('forgot_password')->default(false);

            $table->string('renovation_code')->nullable();

            $table->timestamp('renovation_date')->nullable();

            $table->timestamp('renovation_code_issue_date')->nullable();

            $table->timestamp('renovation_code_expiration_date')->nullable();

            $table->timestamp('last_login_date')->nullable();

            $table->boolean('active')->default(true);

            $table->boolean('was_imported')->default(false);

            $table->boolean('first_login')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('logins');
    }
};
