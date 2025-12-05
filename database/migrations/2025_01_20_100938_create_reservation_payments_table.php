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
        Schema::create('reservation_payments', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_id',20)->nullable();
            $table->string('reservation_room_id',20)->nullable();
            $table->string('amount_paid',25)->nullable();
            $table->string('payment_Date',30)->nullable();
            $table->string('payment_type',50)->nullable();
            $table->string('deposite_status',20)->nullable();
            $table->text('note')->nullable();
            $table->string('note_show_status',20)->nullable();
            $table->string('email_invoice_status',20)->nullable();
            $table->string('guest_email',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_payments');
    }
};
