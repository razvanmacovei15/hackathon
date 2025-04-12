<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('income_sources', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('name'); // e.g., "Main Job", "Freelance Work", "Investment Dividends"
            $table->string('type'); // e.g., "salary", "investment", "business", "rental", "other"
            $table->decimal('amount', 10, 2);
            $table->enum('frequency', ['monthly', 'yearly', 'one_time']);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->text('description')->nullable();
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('income_sources');
    }
}; 