<?php

namespace Database\Seeders;

use App\Models\Package;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PackageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $package_names = ['bronze','silver','gold','platinum'];

        foreach ($package_names as $package_name){
            $package = Package::create([
                'package_name' => $package_name
            ]);
        }
    }
}
