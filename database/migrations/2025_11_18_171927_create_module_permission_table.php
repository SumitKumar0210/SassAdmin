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
        if (!Schema::hasTable('module_permission')) {
            Schema::create('module_permission', function (Blueprint $table) {
                $table->id();
                $table->integer('module_id')->nullable();
                $table->string('module',50)->nullable();
                $table->string('module_option',50)->nullable();
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
        Schema::dropIfExists('module_permission');
    }
};
