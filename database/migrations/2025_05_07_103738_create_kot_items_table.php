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
        if (!Schema::hasTable('kot_items')) {
            Schema::create('kot_items', function (Blueprint $table) {
                $table->id();
                $table->integer('kot_id')->nullable();
                $table->integer('item_id')->nullable();
                $table->string('item_name', 121)->nullable();
                $table->integer('qty')->default(0);
                $table->double('price')->default(0);
                $table->double('total')->default(0);
                $table->double('gst')->default(0);
                $table->double('gst_amount')->default(0);
                $table->double('grand_amount')->default(0);
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
        Schema::dropIfExists('kot_items');
    }
};
