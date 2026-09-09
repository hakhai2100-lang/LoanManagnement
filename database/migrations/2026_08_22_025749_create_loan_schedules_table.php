<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('loan_schedules', function (Blueprint $table) {
            $table->id('schedule_id');
            $table->foreignId('loan_id')->constrained('loans', 'loan_id')->onDelete('cascade');
            $table->integer('installment_no');
            $table->date('due_date');
            $table->decimal('principal_due', 12, 2);
            $table->decimal('interest_due', 12, 2);
            $table->decimal('total_due', 12, 2);
            $table->enum('status', ['Pending', 'Paid', 'Overdue'])->default('Pending');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loan_schedules');
    }
};