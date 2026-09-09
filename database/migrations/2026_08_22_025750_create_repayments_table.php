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
        Schema::create('repayments', function (Blueprint $table) {
            $table->id('repayment_id');
            $table->foreignId('loan_id')->constrained('loans', 'loan_id')->onDelete('cascade');
            $table->foreignId('schedule_id')->nullable()->constrained('loan_schedules', 'schedule_id')->nullOnDelete();
            $table->decimal('amount_paid', 12, 2);
            $table->date('payment_date');
            $table->string('payment_method')->default('Cash');
            $table->foreignId('received_by')->constrained('users'); // User ID របស់ Cashier
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('repayments');
    }
};