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
        Schema::create('folder_group', function (Blueprint $table) {

            $table->id();

            $table->unsignedBigInteger('folder_id');
            $table->foreign('folder_id')->references('id')->on('folders')->onDelete('cascade');
        
            $table->unsignedBigInteger('group_id');
            $table->foreign('group_id')->references('id')->on('groups')->onDelete('cascade');
        
            $table->boolean('can_read')->default(false);
            
            $table->boolean('can_write')->default(false);

            $table->boolean('active')->default(true);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('folder_group');
    }
};
