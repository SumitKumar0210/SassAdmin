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
        if (!Schema::hasTable('advance_amounts')) {
            Schema::create('advance_amounts', function (Blueprint $table) {
                $table->id();
                $table->string('reservation_id',80)->nullable();
                $table->double('amount')->default(0);
                $table->string('type',80)->nullable();
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
        Schema::dropIfExists('advance_amounts');
    }
};
