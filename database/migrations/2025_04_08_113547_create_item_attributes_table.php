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
        if (!Schema::hasTable('item_attributes')) {
            Schema::create('item_attributes', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->nullable();
                $table->string('type', 50)->default('Item');
                $table->integer('allow_multiple')->default(0);
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
        Schema::dropIfExists('item_attributes');
    }
};
