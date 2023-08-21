<?php

namespace Database\Seeders;

use App\Models\Agency;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;


class AgencySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $filePath = resource_path('js/fields.json'); // Adjust the file path

        $jsonContent = File::get($filePath);

        $jsonData = json_decode($jsonContent);

        $agencies = array_filter($jsonData, function ($item) {
            // Filter Items where it's Agency formLabel
            if(isset($item->formLabel)){
                return $item->formLabel == 'Agency';
            }else{
                return 0;
            }
        });
        $agencies = array_values($agencies);
        $items = $agencies[0]->items;
        foreach ($items as $item){
            Agency::create([
                'bitrix_agency_id'=> $item->ID,
                'agency_name' => $item->VALUE
            ]);
        }

    }
}
