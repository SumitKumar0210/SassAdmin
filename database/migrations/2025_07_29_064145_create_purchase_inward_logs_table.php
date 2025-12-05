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
        if (!Schema::hasTable('purchase_inward_logs')) {
            Schema::create('purchase_inward_logs', function (Blueprint $table) {
                $table->id();
                $table->integer('purchase_id')->nullable();
                $table->integer('item_id')->nullable();
                $table->double('total_qty')->default(0);
                $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('purchase_inward_logs');
    }
};
