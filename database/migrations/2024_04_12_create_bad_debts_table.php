<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('bad_debt_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // e.g., "Credit Card", "Car Loan", "Personal Loan"
            $table->string('icon')->nullable();
            $table->boolean('is_default')->default(false);
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_bad_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('bad_debt_categories')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('minimum_payment', 10, 2);
            $table->decimal('interest_rate', 5, 2);
            $table->decimal('current_balance', 10, 2);
            $table->date('start_date');
            $table->date('due_date')->nullable();
            $table->integer('term_months')->nullable(); // For loans with fixed terms
            $table->string('account_number')->nullable();
            $table->string('lender_name')->nullable();
            $table->text('notes')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });

        Schema::create('bad_debts', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('bad_debt_categories')->onDelete('cascade');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('minimum_payment', 10, 2);
            $table->decimal('current_balance', 10, 2);
            $table->date('start_date');
            $table->decimal('interest_rate', 5, 2)->nullable();
            $table->text('notes')->nullable();
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_bad_debts');
        Schema::dropIfExists('bad_debt_categories');
        Schema::dropIfExists('bad_debts');
    }
}; 