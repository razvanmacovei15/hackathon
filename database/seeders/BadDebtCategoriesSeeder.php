<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\BadDebtCategory;

class BadDebtCategoriesSeeder extends Seeder
{
    public function run()
    {
        $categories = [
            [
                'name' => 'Credit Card',
                'icon' => 'credit-card',
                'is_default' => true,
                'description' => 'Credit card debt and revolving credit lines'
            ],
            [
                'name' => 'Car Loan',
                'icon' => 'car',
                'is_default' => true,
                'description' => 'Auto loans and vehicle financing'
            ],
            [
                'name' => 'Personal Loan',
                'icon' => 'hand-holding-usd',
                'is_default' => true,
                'description' => 'Unsecured personal loans'
            ],
            [
                'name' => 'Payday Loan',
                'icon' => 'money-bill-wave',
                'is_default' => true,
                'description' => 'Short-term, high-interest loans'
            ],
            [
                'name' => 'Medical Debt',
                'icon' => 'hospital',
                'is_default' => true,
                'description' => 'Medical bills and healthcare expenses'
            ],
            [
                'name' => 'Student Loan',
                'icon' => 'graduation-cap',
                'is_default' => true,
                'description' => 'Education loans and student debt'
            ],
            [
                'name' => 'Retail Credit',
                'icon' => 'store',
                'is_default' => true,
                'description' => 'Store credit cards and retail financing'
            ]
        ];

        foreach ($categories as $category) {
            BadDebtCategory::create($category);
        }
    }
} 