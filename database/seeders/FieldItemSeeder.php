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

        $res = \CRest::call('crm.dealcategory.stage.list');
        $stages = $res["result"];

        $field = Field::where('field_name', 'STAGE_ID')->first();
        if ($field) {
            foreach ($stages as $stage) {
                FieldItem::create([
                    'item_value' => $stage['NAME'],
                    'item_id' => $stage['STATUS_ID'],
                    'field_id' => $field->field_id
                ]);
            }
        }

        $res = \CRest::call('crm.dealcategory.list');
        $stages = $res["result"];

        $field = Field::where('field_name', 'CATEGORY_ID')->first();
        if ($field) {
            foreach ($stages as $stage) {
                FieldItem::create([
                    'item_value' => $stage['NAME'],
                    'item_id' => $stage['ID'],
                    'field_id' => $field->field_id
                ]);
            }
        }

        $res = \CRest::call('crm.status.list');
        $stages = $res["result"];

        $field = Field::where('field_name', 'TYPE_ID')->first();
        if ($field) {
            foreach ($stages as $stage) {
                FieldItem::create([
                    'item_value' => $stage['NAME'],
                    'item_id' => $stage['ID'],
                    'field_id' => $field->field_id
                ]);
            }
        }


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
