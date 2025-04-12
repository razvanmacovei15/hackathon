<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('household_members', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name');
            $table->timestamps();
        });

        Schema::create('household_member_incomes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('household_member_id')->constrained()->onDelete('cascade');
            $table->string('income_type'); // e.g., 'salary', 'bonus', 'commission', 'investment', 'other'
            $table->decimal('amount', 10, 2);
            $table->enum('frequency', ['monthly', 'yearly', 'one_time']);
            $table->string('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('household_member_incomes');
        Schema::dropIfExists('household_members');
    }
}; 