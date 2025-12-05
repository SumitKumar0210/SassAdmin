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
        Schema::create('email_links', function (Blueprint $table) {
            $table->id();
            $table->string('email',100)->nullable()->unique();
            $table->string('token',50)->nullable();
            $table->string('magic_link',200)->nullable();
            $table->string('status',20)->default('active')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('email_links');
    }
};

