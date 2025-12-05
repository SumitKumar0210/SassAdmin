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
        if (!Schema::hasTable('customers')) {
            Schema::create('customers', function (Blueprint $table) {
                $table->id();
                $table->string('guest_id',50)->nullable();
                $table->string('first_name',40)->nullable();
                $table->string('last_name',40)->nullable();
                $table->string('email',80)->nullable();
                $table->string('password',80)->nullable();
                $table->string('mobile',15)->nullable();
                $table->string('id_proof',80)->nullable();
                $table->string('gender',15)->nullable();
                $table->string('allergic_to',80)->nullable();
                $table->string('address',50)->nullable();
                $table->string('city',25)->nullable();
                $table->string('state',30)->nullable();
                $table->string('country',50)->nullable();
                $table->string('pincode',15)->nullable();
                $table->string('company_name',40)->nullable();
                $table->string('gst_number',20)->nullable();
                $table->string('remember_token',191)->nullable();
                $table->string('note',191)->nullable();
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
