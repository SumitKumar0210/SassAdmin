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
        Schema::create('roomclose_dates', function (Blueprint $table) {
            $table->id();
            $table->integer('room_closure_id')->nullable();
            $table->string('room_num',11)->nullable();
            $table->date('room_closure_dates')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('roomclose_dates');
    }
};
