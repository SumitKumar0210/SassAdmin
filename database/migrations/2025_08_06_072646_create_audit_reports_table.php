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
        if (!Schema::hasTable('audit_reports')) {
            Schema::create('audit_reports', function (Blueprint $table) {
                $table->id();
                $table->integer('audit_progress')->default(0);
                $table->integer('guest_folio_review_status')->default(0);
                $table->integer('room_review_status')->default(0);
                $table->integer('revenue_review_status')->default(0);
                $table->integer('closer_review_status')->default(0);
                $table->integer('f_b_audit_status')->default(0);
                $table->date('date')->nullable();
                $table->datetime('start_datetime')->nullable();
                $table->datetime('end_datetime')->nullable();
                $table->string('start_time', 25)->nullable();
                $table->string('last_time', 25)->nullable();
                $table->integer('status')->default(1);
                $table->integer('audit_by')->nullable();
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
        Schema::dropIfExists('audit_reports');
    }
};
