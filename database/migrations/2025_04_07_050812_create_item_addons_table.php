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
        if (!Schema::hasTable('item_addons')) {
            Schema::create('item_addons', function (Blueprint $table) {
                $table->id();
                $table->integer('item_id')->nullable();
                $table->integer('addon_item_id')->nullable();
                $table->string('variation', 30)->nullable();
                $table->double('price')->default(0);
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
        Schema::dropIfExists('item_addons');
    }
};
