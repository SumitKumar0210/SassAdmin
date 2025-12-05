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
        Schema::create('reservation_rooms', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_id',20)->nullable();
            $table->string('primary_name',100)->nullable();
            $table->string('status',20)->default('reserved');
            $table->string('room_alloted',20)->default('NA');
            $table->date('checkin')->nullable();
            $table->date('checkout')->nullable();
            $table->string('guest_status',20)->default('pending');
            $table->integer('daystay')->default(0);
            $table->integer('room_category_id')->default(0);
            $table->string('room_category',11)->nullable();
            $table->integer('room_type_id',11)->default(0);
            $table->integer('tariff_id',11)->nullable();
            $table->string('room_type',50)->nullable();
            $table->string('rate_plan',20)->nullable();
            $table->string('rooms',20)->nullable();
            $table->string('adults',20)->nullable();
            $table->string('childrens',20)->nullable();
            $table->string('infants',20)->nullable();
            $table->double('amount', 20, 2)->default(0);
            $table->int('extra_person',11)->default(0);
            $table->double('discount', 20, 2)->default(0);
            $table->double('paid_amount')->default(0);
            $table->string('notes',400)->default('');
            $table->integer('invoice_view_count',11)->default('0');
            $table->string('dragged_row',20)->nullable();
            $table->string('dragged_col',20)->nullable();
            $table->string('dropped_row',20)->nullable();
            $table->string('dropped_row',20)->nullable();
            $table->dateTime('checkedin_at')->nullable();
            $table->dateTime('checkedout_at')->nullable();
            $table->string('dropped_checkin_date',30)->nullable();
            $table->string('dropped_checkout_date',30)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservation_rooms');
    }
};
