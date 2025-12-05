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
        if (!Schema::hasTable('measurements')) {
            Schema::create('measurements', function (Blueprint $table) {
                $table->id();
                $table->string('name', 30)->nullable();
                $table->string('short_name', 15)->nullable();
                $table->string('child_name', 30)->nullable();
                $table->string('child_symbol', 15)->nullable();
                $table->integer('status')->default(1);
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
        Schema::dropIfExists('measurements');
    }
};
