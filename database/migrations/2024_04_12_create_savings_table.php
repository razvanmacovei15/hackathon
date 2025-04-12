<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::create('saving_categories', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description')->nullable();
            $table->timestamps();
        });

        Schema::create('user_savings', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->foreignId('category_id')->constrained('saving_categories')->onDelete('cascade');
            $table->decimal('target_amount', 10, 2);
            $table->decimal('current_amount', 10, 2)->default(0);
            $table->decimal('monthly_contribution', 10, 2);
            $table->string('description')->nullable();
            $table->date('target_date')->nullable();
            $table->boolean('is_emergency_fund')->default(false)->nullable();
            $table->enum('priority', ['low', 'medium', 'high'])->default('medium');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('user_savings');
        Schema::dropIfExists('saving_categories');
    }
}; 