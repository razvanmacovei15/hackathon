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
        Schema::table('user_bad_debts', function (Blueprint $table) {
            $table->decimal('interest_rate', 5, 2)->nullable()->change();
            $table->dropColumn(['due_date', 'term_months', 'account_number', 'lender_name']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('user_bad_debts', function (Blueprint $table) {
            $table->decimal('interest_rate', 5, 2)->change();
            $table->date('due_date')->nullable();
            $table->integer('term_months')->nullable();
            $table->string('account_number')->nullable();
            $table->string('lender_name')->nullable();
        });
    }
};
