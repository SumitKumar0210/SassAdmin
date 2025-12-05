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
        if (!Schema::hasTable('payment_receiveds')) {
            Schema::create('payment_receiveds', function (Blueprint $table) {
                $table->id();
                $table->string('type',30)->nullable();
                $table->integer('type_id')->nullable();
                $table->string('payment_mode',30)->nullable();
                $table->string('txn_number',80)->nullable();
                $table->double('amount')->default(0);
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
        Schema::dropIfExists('payment_receiveds');
    }
};
