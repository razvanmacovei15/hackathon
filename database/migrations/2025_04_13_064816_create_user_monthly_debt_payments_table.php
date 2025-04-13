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
        Schema::create('user_monthly_debt_payments', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('debt_type_id')->constrained('debt_types')->onDelete('cascade');
            $table->string('name');
            $table->decimal('total_amount', 10, 2);
            $table->decimal('remaining_amount', 10, 2);
            $table->decimal('minimum_payment', 10, 2);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_monthly_debt_payments');
    }
};
