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
        Schema::create('room_types', function (Blueprint $table) {
            $table->id();
            $table->integer('room_category_id',11)->default(0);
            $table->string('room_category',50)->nullable();
            $table->integer('roomtype_name_id',11)->default(0);
            $table->string('roomtype_name',50)->nullable();
            $table->string('internal_roomtype',50)->nullable();
            $table->double('internal_roomtype')->default(0);
            $table->string('description',250)->nullable();
            $table->string('max_occupancy',50)->nullable();
            $table->string('max_adult',50)->nullable();
            $table->string('max_child',50)->nullable();
            $table->string('max_infant',50)->nullable();
            $table->string('room_size',50)->nullable();
            $table->string('bathroom',50)->nullable();
            $table->string('smoking_category',20)->nullable();
            $table->string('room_view',200)->nullable();
            $table->string('ami_facilities',200)->nullable();
            $table->string('bed_type',50)->nullable();
            $table->string('bedtype_count',50)->nullable();
            $table->string('room_category_types',200)->nullable();
            $table->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_types');
    }
};
