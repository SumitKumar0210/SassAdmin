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
        if (!Schema::hasTable('banquet_menu_items')) {
            Schema::create('banquet_menu_items', function (Blueprint $table) {
            $table->id();
                $table->integer('booking_id')->nullable();
                $table->integer('menu_category_id')->nullable();
                $table->string('menu_category_name', 50)->nullable();
                $table->string('serve_time', 50)->nullable();
                $table->integer('item_id')->nullable();
                $table->string('item_name', 50)->nullable();
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
        Schema::dropIfExists('banquet_menu_items');
    }
};
