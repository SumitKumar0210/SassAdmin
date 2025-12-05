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
        if (!Schema::hasTable('banquet_bookings')) {
            Schema::create('banquet_bookings', function (Blueprint $table) {
                $table->id();
                $table->date('event_date')->nullable();
                $table->integer('event_id')->nullable();
                $table->string('event_name', 50)->nullable();
                $table->string('start_time', 50)->nullable();
                $table->date('event_end_date')->nullable();
                $table->string('end_time', 50)->nullable();
                $table->string('client_name', 50)->nullable();
                $table->string('company_name', 50)->nullable();
                $table->string('company_gst', 30)->nullable();
                $table->integer('expected_guest_count')->nullable();
                $table->string('contact_no', 15)->nullable();
                $table->integer('hall_id')->nullable();
                $table->string('hall_name',25)->nullable();
                $table->integer('hall_capacity')->nullable();
                $table->string('hall_setup_time',25)->nullable();
                $table->double('hall_rate')->nullable();
                $table->double('hall_charge')->nullable();
                $table->double('discount')->nullable();
                $table->double('discount_amount')->nullable();
                $table->integer('complimentary_room')->nullable();
                $table->integer('extra_room')->nullable();
                $table->integer('per_room_capacity')->nullable();
                $table->integer('per_room_charge')->nullable();
                $table->string('food_consumption_type')->nullable();
                $table->double('total_hall_charge')->nullable();
                $table->double('total_food_charge')->nullable();
                $table->double('total_accesories_charge')->nullable();
                $table->double('extra_room_charge')->nullable();
                $table->double('sub_total')->nullable();
                $table->double('total_discount')->nullable();
                $table->double('total_discount_amount')->nullable();
                $table->double('total_amount')->nullable();
                $table->double('gst')->nullable();
                $table->double('gst_amount')->nullable();
                $table->double('grand_total')->nullable();
                $table->double('adjustment')->nullable();
                $table->double('advance_paid')->nullable();
                $table->double('due')->nullable();
                $table->string('note')->nullable();
                $table->string('payment_mode')->nullable();
                $table->string('reference_number')->nullable();
                $table->integer('created_by')->nullable();
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
        Schema::dropIfExists('banquet_bookings');
    }
};
