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
        if (!Schema::hasTable('companies')) {
            Schema::create('companies', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->nullable();
                $table->string('address', 50)->nullable();
                $table->string('logo', 255)->nullable();
                $table->string('area', 50)->nullable();
                $table->string('state', 50)->nullable();
                $table->string('gst', 100)->nullable();
                $table->string('mobile', 20)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('status', 11)->default('active');
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
        Schema::dropIfExists('companies');
    }
};
