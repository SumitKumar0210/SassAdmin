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
        if (!Schema::hasTable('items')) {
            Schema::create('items', function (Blueprint $table) {
                $table->id();
                $table->string('code', 30)->nullable();
                $table->string('name', 30)->nullable();
                $table->integer('uom')->nullable();
                $table->double('price')->default(0);
                $table->double('offer_price')->default(0);
                $table->float('gst')->default(0);
                $table->double('gst_amount')->default(0);
                $table->double('total')->default(0);
                $table->integer('label')->nullable();
                $table->integer('category')->nullable();
                $table->integer('sub_category')->nullable();
                $table->string('image',255)->nullable();
                $table->string('type',30)->nullable();
                $table->integer('only_internal')->default(0);
                $table->string('description')->nullable();
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
        Schema::dropIfExists('items');
    }
};
