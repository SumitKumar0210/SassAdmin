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
        Schema::create('reservations', function (Blueprint $table) {
            $table->id();
            $table->string('reservation_id',20)->nullable()->unique();
            $table->string('status',20)->default('Reserved');
            $table->string('name',100)->nullable();
            $table->string('mobile',15)->nullable();
            $table->string('email',100)->default('');
            $table->string('address',200)->default('');
            $table->string('city',80)->default('');
            $table->string('state',80)->default('');
            $table->string('pin',6)->default('');
            $table->string('gender',10)->default('');
            $table->string('arrival_time',50)->default('');
            $table->string('document_type',50)->default('');
            $table->string('other_document_type',50)->default('');
            $table->string('id_number',50)->default('');
            $table->string('comments',200)->default('');
            $table->string('company_name',100)->default('');
            $table->string('company_gst',50)->default('');
            $table->text('company_address')->default('');
            $table->string('notes',400)->default('');
            $table->string('guest_type',25)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reservations');
    }
};
