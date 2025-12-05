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
        if (!Schema::hasTable('store_requests')) {
            Schema::create('store_requests', function (Blueprint $table) {
                $table->id();
                $table->string('str_no',30)->nullable();
                $table->integer('item_id')->nullable();
                $table->integer('expected_qty')->default(0);
                $table->integer('received_qty')->default(0);
                $table->integer('unit')->nullable();
                $table->integer('vendor_id')->nullable();
                $table->integer('created_by')->nullable();
                $table->integer('request_from')->nullable();
                $table->dateTime('date_of_transfer')->nullable();
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
        Schema::dropIfExists('store_requests');
    }
};
