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
        Schema::create('employees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('department_id')->constrained('departments')->cascadeOnDelete();
            $table->string('first_name');
            $table->string('last_name');
            $table->string('email');
            $table->string('employee_number')->unique(); // رقم الموظف يجب أن يكون فريدا لكي يتميز الموظف عن غيره
            $table->string('phone');
            $table->string('position'); // المسمى الوظيفي
            $table->decimal('salary' , 10,2);
            $table->date('hire_date'); // تاريخ التعيين
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('employees');
    }
};