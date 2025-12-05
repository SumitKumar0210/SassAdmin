<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // database/migrations/xxxx_xx_xx_create_room_type_images_table.php
        Schema::create('roomtype_images', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('roomtype_id');
            $table->string('file_name');
            $table->string('file_path');
            $table->timestamps();

            $table->foreign('roomtype_id')->references('id')->on('room_types')->onDelete('cascade');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomtype_images');
    }
};
