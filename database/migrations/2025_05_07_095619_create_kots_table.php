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
        if (!Schema::hasTable('kots')) {
            Schema::create('kots', function (Blueprint $table) {
                $table->id();
                $table->integer('kot_id')->nullable();
                $table->integer('reserve_room_id')->nullable();
                $table->integer('type')->nullable();
                $table->integer('type_number')->nullable();
                $table->date('date')->nullable();
                $table->datetime('order_time')->nullable();
                $table->integer('total_item_qty')->default(0);
                $table->string('note', 121)->nullable();
                $table->integer('is_complimentary')->default(0);
                $table->integer('waiter_id')->nullable();
                $table->integer('apply_coupon')->default(0);
                $table->string('coupon_code',150)->nullable();
                $table->integer('coupon_id')->nullable();
                $table->double('coupon_amount')->default(0);
                $table->double('total')->default(0);
                $table->integer('discount_type')->nullable();
                $table->integer('discount_value')->nullable();
                $table->double('sub_total')->default(0);
                $table->double('total_gst')->default(0);
                $table->double('adjustment')->default(0);
                $table->double('grand_total')->default(0);
                $table->double('total_paid')->default(0);
                $table->integer('payment_type')->nullable();
                $table->string('card_number', 121)->nullable();
                $table->integer('upi_type')->nullable();
                $table->integer('reference_number')->nullable();
                $table->string('contact_person_name', 121)->nullable();
                $table->string('contact_person_mobile', 30)->nullable();
                $table->integer('contact_person_email')->nullable();
                $table->string('order_status', 30)->default('Pending');
                $table->datetime('cancel_at')->nullable();
                $table->string('cancel_reason', 91)->nullable();
                $table->string('status')->default(1);
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
        Schema::dropIfExists('kots');
    }
};
