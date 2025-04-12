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
        Schema::create('user_financial_profiles', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->cascadeOnDelete();
            $table->decimal('household_income', 10, 2)->nullable();
            $table->decimal('food_expenses', 10, 2)->nullable();
            $table->decimal('transport_expenses', 10, 2)->nullable();
            $table->decimal('bills_expenses', 10, 2)->nullable();
            $table->decimal('car_loan', 10, 2)->nullable();
            $table->decimal('mortgage', 10, 2)->nullable();
            $table->decimal('credit_card_debt', 10, 2)->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_financial_profiles');
    }
};
