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
        if (!Schema::hasTable('tariffs')) {
            Schema::create('tariffs', function (Blueprint $table) {
                $table->id();
                $table->integer('room_category_id')->nullable();
                $table->integer('roomtype_name_id')->nullable();
                $table->string('tariff_type',200)->nullable();
                $table->double('room_tariff')->default(0);
                $table->double('extra_person_tariff')->default(0);
                $table->string('status',11)->default('active');
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
        Schema::dropIfExists('tariffs');
    }
};
