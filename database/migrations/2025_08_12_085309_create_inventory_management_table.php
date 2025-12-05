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
        if (!Schema::hasTable('inventory_management')) {
            Schema::create('inventory_management', function (Blueprint $table) {
                $table->id();
                $table->integer('item_id')->nullable();
                $table->string('item_name',100)->nullable();
                $table->integer('department_id')->nullable();
                $table->date('txn_date')->nullable();
                $table->double('qty_in')->default(0);
                $table->double('qty_out')->default(0);
                $table->double('balance')->default(0);
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
        Schema::dropIfExists('inventory_management');
    }
};
