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
        Schema::create('day_requests', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('requested_by');
            $table->foreign('requested_by')->references('id')->on('users')->onDelete('cascade');

            $table->unsignedBigInteger('day_id');
            $table->foreign('day_id')->references('id')->on('days')->onDelete('cascade');

            $table->integer('requested_days')->nullable();

            $table->timestamp('start_date')->nullable();

            $table->timestamp('end_date')->nullable();

            $table->string('status')->default('Pending');

            $table->unsignedBigInteger('updated_by')->nullable();
            $table->foreign('updated_by')->references('id')->on('users')->onDelete('cascade');

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('day_requests');
    }
};
