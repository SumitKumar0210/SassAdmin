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
        if (!Schema::hasTable('reservation_invoices')) {
            Schema::create('reservation_invoices', function (Blueprint $table) {
                $table->id();
                $table->string('status',30)->nullable();
                $table->integer('room_id',11)->nullable();
                $table->string('reservation_id',30)->nullable();
                $table->integer('room_num',11)->nullable();
                $table->string('room_type',30)->nullable();
                $table->timestamp('checkin',30)->nullable();
                $table->timestamp('checkout',30)->nullable();
                $table->string('name',100)->nullable();
                $table->string('mobile',15)->nullable();
                $table->string('email',100)->nullable();
                $table->text('address')->nullable();
                $table->double('amount')->nullable();
                $table->double('discount')->nullable();
                $table->double('paid_amount')->nullable();
                $table->string('company_name',100)->nullable();
                $table->string('company_gst',50)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_invoices');
    }
};
