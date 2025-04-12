<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DefaultCategoriesSeeder extends Seeder
{
    public function run()
    {
        // Default Earning Categories
        $earningCategories = [
            ['name' => 'Salary', 'icon' => 'briefcase', 'is_default' => true],
            ['name' => 'Freelance', 'icon' => 'laptop', 'is_default' => true],
            ['name' => 'Investments', 'icon' => 'trending-up', 'is_default' => true],
            ['name' => 'Rental Income', 'icon' => 'home', 'is_default' => true],
            ['name' => 'Side Business', 'icon' => 'shopping-bag', 'is_default' => true],
        ];

        foreach ($earningCategories as $category) {
            DB::table('earning_categories')->insert([
                'name' => $category['name'],
                'icon' => $category['icon'],
                'is_default' => $category['is_default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Default Essential Expense Categories
        $essentialExpenseCategories = [
            ['name' => 'Rent/Mortgage', 'icon' => 'home', 'is_default' => true],
            ['name' => 'Utilities', 'icon' => 'zap', 'is_default' => true],
            ['name' => 'Groceries', 'icon' => 'shopping-cart', 'is_default' => true],
            ['name' => 'Transportation', 'icon' => 'truck', 'is_default' => true],
            ['name' => 'Healthcare', 'icon' => 'activity', 'is_default' => true],
            ['name' => 'Insurance', 'icon' => 'shield', 'is_default' => true],
        ];

        foreach ($essentialExpenseCategories as $category) {
            DB::table('essential_expense_categories')->insert([
                'name' => $category['name'],
                'icon' => $category['icon'],
                'is_default' => $category['is_default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Default Debt Categories
        $debtCategories = [
            ['name' => 'Credit Card', 'icon' => 'credit-card', 'is_default' => true],
            ['name' => 'Car Loan', 'icon' => 'car', 'is_default' => true],
            ['name' => 'Student Loan', 'icon' => 'book', 'is_default' => true],
            ['name' => 'Personal Loan', 'icon' => 'dollar-sign', 'is_default' => true],
            ['name' => 'Mortgage', 'icon' => 'home', 'is_default' => true],
        ];

        foreach ($debtCategories as $category) {
            DB::table('debt_categories')->insert([
                'name' => $category['name'],
                'icon' => $category['icon'],
                'is_default' => $category['is_default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

        // Default Saving Categories
        $savingCategories = [
            ['name' => 'Emergency Fund', 'icon' => 'alert-circle', 'is_default' => true],
            ['name' => 'Vacation', 'icon' => 'plane', 'is_default' => true],
            ['name' => 'Car', 'icon' => 'car', 'is_default' => true],
            ['name' => 'Home Down Payment', 'icon' => 'home', 'is_default' => true],
            ['name' => 'Retirement', 'icon' => 'sunset', 'is_default' => true],
            ['name' => 'Education', 'icon' => 'book', 'is_default' => true],
        ];

        foreach ($savingCategories as $category) {
            DB::table('saving_categories')->insert([
                'name' => $category['name'],
                'icon' => $category['icon'],
                'is_default' => $category['is_default'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
} 