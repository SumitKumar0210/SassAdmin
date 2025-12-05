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
        if (!Schema::hasTable('banquet_accesories')) {
            Schema::create('banquet_accesories', function (Blueprint $table) {
                $table->id();
                $table->integer('booking_id')->nullable();
                $table->integer('accesories_id')->nullable();
                $table->string('accesories_name', 50)->nullable();
                $table->double('accesories_rate')->nullable();
                $table->integer('accesories_qty')->nullable();
                $table->double('accesories_amount')->nullable();
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
        Schema::dropIfExists('banquet_accesories');
    }
};
