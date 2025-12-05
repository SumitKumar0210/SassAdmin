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
        Schema::create('room_numbers', function (Blueprint $table) {
            $table->id();
            $table->integer('category_id')->nullable();
            $table->string('room_category',30)->nullable();
            $table->integer('roomtype_id')->nullable();
            $table->string('roomtype_name',30)->nullable();
            $table->string('room_number',30)->nullable();
            $table->string('qr_code',80)->nullable();
            $table->string('random_code',91)->nullable();
            $table->dateTime('booked_date')->nullable();
            $table->string('previous_status',20)->nullable();
            $table->string('current_status',20)->default('vacant');
            $table->date('c_status_date_from')->nullable();
            $table->date('c_status_date_to')->nullable();
            $table->string('status',10)->default('active');
            $table ->dateTime('deleted_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_numbers');
    }
};
