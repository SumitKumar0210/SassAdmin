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
        if (!Schema::hasTable('raw_materials')) {
            Schema::create('raw_materials', function (Blueprint $table) {
                $table->id();
                $table->string('code', 25)->nullable();
                $table->string('name', 50)->nullable();
                $table->integer('uom')->nullable();
                $table->integer('qty')->nullable();
                $table->integer('min_qty')->default(1);
                $table->integer('max_qty')->nullable();
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
        Schema::dropIfExists('raw_materials');
    }
};
