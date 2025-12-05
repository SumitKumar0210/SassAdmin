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
        if (!Schema::hasTable('hotlr_configurations')) {
            Schema::create('hotlr_configurations', function (Blueprint $table) {
                $table->id();
                $table->string('name', 50)->nullable();
                $table->string('address', 50)->nullable();
                $table->string('city', 50)->nullable();
                $table->string('state', 50)->nullable();
                $table->string('pincode', 25)->nullable();
                $table->string('logo', 255)->nullable();
                $table->string('restaurant_area', 50)->nullable();
                $table->string('state', 50)->nullable();
                $table->string('gst', 100)->nullable();
                $table->string('mobile', 20)->nullable();
                $table->string('email', 100)->nullable();
                $table->string('invoice_prefix', 25)->nullable();
                $table->integer('status')->default(1);
                $table->integer('suffix_length')->default(4);
                $table->integer('invoice_no')->default(1);
                $table->string('gst', 25)->nullable();
                $table->string('audit_start', 10)->nullable();
                $table->string('audit_end', 10)->nullable();
                $table->integer('duration')->default(0);
                $table->string('gst', 25)->nullable();
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
        Schema::dropIfExists('holtr_configurations');
    }
};
