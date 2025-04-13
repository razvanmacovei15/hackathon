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
        Schema::create('user_financial_situations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->decimal('total_earnings', 10, 2)->default(0);
            $table->decimal('total_debt', 10, 2)->default(0);
            $table->decimal('total_remaining_debt', 10, 2)->default(0);
            $table->decimal('total_savings', 10, 2)->default(0);
            $table->decimal('total_remaining_savings_goal', 10, 2)->default(0);
            $table->decimal('total_expenses', 10, 2)->default(0);
            $table->decimal('total_mortgage', 10, 2)->default(0);
            $table->decimal('total_remaining_mortgage', 10, 2)->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_financial_situations');
    }
};
