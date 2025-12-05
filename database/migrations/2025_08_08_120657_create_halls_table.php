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
        if (!Schema::hasTable('halls')) {
            Schema::create('halls', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->nullable();
                $table->integer('capacity')->default(1);
                $table->string('area', 50)->nullable();
                $table->string('setup_time', 50)->nullable();
                $table->double('rate')->nullable();
                $table->integer('complimentary_rooms')->nullable();
                $table->string('features', 50)->nullable();
                $table->integer('status')->default(1);
                $table->integer('availability')->default(0);
                $table->date('booked_date')->nullable();
                $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('halls');
    }
};
