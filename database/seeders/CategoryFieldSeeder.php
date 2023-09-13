<?php

namespace Database\Seeders;

use App\Models\FieldCategory;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CategoryFieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $category_names = ['Personal Information', 'Address', 'Documents', 'Deals', 'Hidden'];

        foreach ($category_names as $category_name) {
            if ($category_name == 'Hidden' || $category_name == 'Deals') {
                $category = FieldCategory::create([
                    'category_name' => $category_name,
                    'is_visible' => false
                ]);
            } else {
                $category = FieldCategory::create([
                    'category_name' => $category_name
                ]);
            }
        }

    }
}
