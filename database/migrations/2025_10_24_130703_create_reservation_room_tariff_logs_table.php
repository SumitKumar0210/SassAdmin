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
        if (!Schema::hasTable('reservation_room_tariff_logs')) {
            Schema::create('reservation_room_tariff_logs', function (Blueprint $table) {
                $table->id();
                $table->date('date')->nullable();
                $table->integer('reservation_id')->nullable();
                $table->string('reservation',30)->nullable();
                $table->integer('reservation_room_id')->nullable();
                $table->integer('room_type_id')->nullable();
                $table->integer('tariff_id')->nullable();
                $table->string('tariff')->nullable();
                $table->integer('room_id')->nullable();
                $table->string('room')->nullable();
                $table->integer('adults')->nullable(0);
                $table->integer('childrens')->nullable(0);
                $table->integer('infants')->nullable(0);
                $table->double('amount')->default(0);
                $table->integer('extra_pax')->default(0);
                $table->double('extra_pax_amount')->default(0);
                $table->integer('day_stay')->default(0);
                $table->double('cost_room')->default(0);
                $table->double('cost_extra_room')->default(0);
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
        Schema::dropIfExists('reservation_room_tariff_logs');
    }
};
