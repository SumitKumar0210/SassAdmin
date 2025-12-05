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
        Schema::create('room_guests', function (Blueprint $table) {
            $table->id();
            $table->string('room_id',10)->nullable();
            $table->string('reservation_id',20)->nullable();
            $table->string('first_name',50)->nullable();
            $table->string('last_name',50)->nullable();
            $table->string('email',80)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('gender',10)->nullable();
            $table->string('document_type',50)->default('');
            $table->string('id_number',100)->default('');
            $table->string('status',11)->default('pending');
            $table->dateTime('checkedin_at')->nullable();
            $table->dateTime('checkedout_at')->nullable();
            $table->string('remarks',100)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('room_guests');
    }
};
