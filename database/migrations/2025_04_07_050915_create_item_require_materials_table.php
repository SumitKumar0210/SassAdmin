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
        if (!Schema::hasTable('item_require_materials')) {
            Schema::create('item_require_materials', function (Blueprint $table) {
                $table->id();
                $table->integer('item_id')->nullable();
                $table->integer('material_id')->nullable();
                $table->integer('qty')->default(1);
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
        Schema::dropIfExists('item_require_materials');
    }
};
