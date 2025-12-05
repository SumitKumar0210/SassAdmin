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
        if (!Schema::hasTable('tables')) {
            Schema::create('tables', function (Blueprint $table) {
                $table->id();
                $table->integer('number')->nullable();
                $table->integer('capacity')->nullable();
                $table->string('area',50)->nullable();
                $table->string('qr_code',80)->nullable();
                $table->string('random_code',91)->nullable();
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
        Schema::dropIfExists('tables');
    }
};
