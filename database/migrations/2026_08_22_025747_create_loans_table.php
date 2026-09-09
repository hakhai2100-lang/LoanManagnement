<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    
    public function up(): void
    {
        Schema::create('loans', function (Blueprint $table) {
            $table->id('loan_id');
            $table->foreignId('customer_id')->constrained('users')->onDelete('cascade');
            $table->decimal('principal_amount', 12, 2);
            $table->decimal('interest_rate', 5, 2); // ឧទាហរណ៍ 2.00%
            $table->integer('term_months');
            $table->enum('status', ['Pending', 'Approved', 'Disbursed', 'Rejected'])->default('Pending');
            $table->date('disbursement_date')->nullable();
            $table->foreignId('created_by')->nullable()->constrained('users')->nullOnDelete();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('loans');
    }
};