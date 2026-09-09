<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('customers', function (Blueprint $table) {

            $table->id();
            $table->string('customer_code',20)->unique();
            $table->string('first_name',50);
            $table->string('last_name',50);
            $table->enum('gender',['Male','Female']);
            $table->date('date_of_birth');
            $table->string('phone',20);
            $table->string('email',100)->unique();
            $table->text('address')->nullable();
            $table->string('city',100);
            $table->enum('status',['Active','Inactive']);
            $table->timestamps();

        });
    }

    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};