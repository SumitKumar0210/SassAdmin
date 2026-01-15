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
        Schema::create('kot_invoices', function (Blueprint $table) {
            $table->id();
            $table->string('invoice_id')->nullable();
            $table->string('type',30)->nullable();
            $table->datetime('invoice_date')->nullable();
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
            $table->double('pay_amount')->default(0);
            $table->string('amount_word')->nullable();
            $table->string('payment_mode',25)->nullable();
            $table->string('reference',50)->nullable();
            $table->integer('received_by')->default(1);
            $table->integer('status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kot_invoices');
    }
};
