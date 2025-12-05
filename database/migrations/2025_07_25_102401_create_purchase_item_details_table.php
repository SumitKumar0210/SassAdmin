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
        if (!Schema::hasTable('purchase_item_details')) {
            Schema::create('purchase_item_details', function (Blueprint $table) {
                $table->id();
                $table->string('purchase_id',30)->nullable();
                $table->integer('item_id')->nullable();
                $table->integer('expected_qty')->default(0);
                $table->integer('received_qty')->default(0);
                $table->string('unit',11)->nullable();
                $table->string('order_status',22)->default('Pending');
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
        Schema::dropIfExists('purchase_item_details');
    }
};
