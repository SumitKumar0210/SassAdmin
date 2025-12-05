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
        if (!Schema::hasTable('room_bed_configurations')) {
            Schema::create('room_bed_configurations', function (Blueprint $table) {
                $table->id();
                $table->integer('roomtype_id')->nullable();
                $table->string('bed_type')->nullable();
                $table->string('no_of_bed')->nullable();
                $table->timestamps();
                $table->softDeletes();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_bed_configurations');
    }
};
