<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldItem;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class FieldItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $res = \CRest::call('crm.deal.fields');

        $values = $res["result"];

        $newArray = array_filter($values, function ($el) {
            return $el['type'] == 'enumeration';
        });

        foreach ($newArray as $key => $value) {
            $fieldId = Field::where("field_name", $key)->pluck('field_id');
            $fieldId = $fieldId[0];

            foreach ($value["items"] as $item) {

                FieldItem::create([
                    'field_id' => $fieldId,
                    'item_value' => $item["VALUE"],
                    'item_id' => $item["ID"]
                ]);

            }
        }


    }
}
