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
        if (!Schema::hasTable('item_variations')) {
            Schema::create('item_variations', function (Blueprint $table) {
                $table->id();
                $table->integer('item_id')->nullable();
                $table->integer('attribute_id')->nullable();
                $table->string('name', 30)->nullable();
                $table->double('price')->default(0);
                $table->string('type',15)->nullable();
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
        Schema::dropIfExists('item_variations');
    }
};
