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
        if (!Schema::hasTable('invoices')) {
            Schema::create('invoices', function (Blueprint $table) {
                $table->id();
                $table->string('invoice_id')->nullable();
                $table->string('type',30)->nullable();
                $table->integer('reservation_id')->nullable();
                $table->string('reservation')->nullable();
                $table->integer('reserved_room_id')->nullable();
                $table->datetime('checkin')->nullable();
                $table->datetime('checkout')->nullable();
                $table->integer('booking_id')->default(0);
                $table->datetime('invoice_date')->nullable();
                $table->integer('no_of_nights')->default(0);
                $table->integer('no_of_rooms')->default(0);
                $table->integer('guest_id')->default(0);
                $table->string('guest_name',50)->nullable();
                $table->string('guest_phone',30)->nullable();
                $table->string('guest_address',50)->nullable();
                $table->string('guest_email',50)->nullable();
                $table->double('total')->default(0);
                $table->double('dis_per')->default(0);
                $table->double('dis_amount')->default(0);
                $table->double('amount_after_discount')->default(0);
                $table->double('cgst_per')->default(0);
                $table->double('sgst_per')->default(0);
                $table->double('igst_per')->default(0);
                $table->double('cgst_amount')->default(0);
                $table->double('sgst_amount')->default(0);
                $table->double('igst_amount')->default(0);
                $table->double('amount_after_tax')->default(0);
                $table->double('round_off')->default(0);
                $table->double('advance_amount')->default(0);
                $table->double('pay_amount')->default(0);
                $table->string('amount_word')->nullable();
                $table->string('payment_mode',25)->nullable();
                $table->string('cheque',50)->nullable();
                $table->string('reference',50)->nullable();
                $table->integer('received_by')->default(1);
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
        Schema::dropIfExists('invoices');
    }
};
