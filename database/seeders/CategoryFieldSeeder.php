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
        $category_names = ['Personal Information','Address','Documents','Deals'];

        foreach ($category_names as $category_name){
            $category = FieldCategory::create([
                'category_name' => $category_name
            ]);
        }
    }
}
