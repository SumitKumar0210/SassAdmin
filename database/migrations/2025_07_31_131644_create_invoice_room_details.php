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
        if (!Schema::hasTable('invoice_room_details')) {
            Schema::create('invoice_room_details', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_id')->nullable();
                $table->integer('reserved_room_id')->nullable();
                $table->integer('room_id')->default(0);
                $table->datetime('invoice_date')->nullable();
                $table->string('room_number',50)->nullable();
                $table->string('room_type',30)->nullable();
                $table->string('room_category',50)->nullable();
                $table->integer('no_of_days')->default(0);
                $table->double('total')->default(0);
                $table->integer('extra_person_no')->default(0);
                $table->double('extra_person_total')->nullable();
                $table->double('subtotal')->default(0);
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
        Schema::dropIfExists('invoice_room_details');
    }
};
