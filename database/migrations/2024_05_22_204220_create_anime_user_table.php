<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('anime_user', function (Blueprint $table) {
            $table->id();
            $table->timestamps();

            // Define foreign key constraints explicitly
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('anime_id')->references('id')->on('anime_list')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('anime_user');
    }
};
