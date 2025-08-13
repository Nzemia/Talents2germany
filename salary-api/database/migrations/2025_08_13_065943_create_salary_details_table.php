<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('salary_details', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('salary_local_currency', 10, 2);
            $table->decimal('salary_in_euros', 10, 2)->nullable();
            $table->decimal('commission', 10, 2)->default(500.00);
            $table->decimal('displayed_salary', 10, 2)->nullable(); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('salary_details');
    }
};