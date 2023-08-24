<?php

namespace Database\Seeders;

use App\Models\Field;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Kafka0238\Crest\Src;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\File;

class FieldSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $res = \CRest::call('crm.deal.fields');

        $arrayOfObjects = [];
        $values = $res["result"];
        $keys = array_keys($res["result"]);
        foreach ($keys as $i => $key) {
            $values[$key]["field_name"] = $key;
            $arrayOfObjects[] = $values[$key];
        }
        $json = json_encode($arrayOfObjects, JSON_PRETTY_PRINT);
//        file_put_contents("fields.json", $json);

        // Path to the public/js directory
        $jsPath = resource_path('js');

        file_put_contents($jsPath . "/fields.json", $json);
        $i = 0;
        foreach ($arrayOfObjects as $object) {
            if (isset($object['formLabel'])) {
                Field::create([
                    'field_name' => $object['field_name'],
                    'type' => $object['type'],
                    'title' => $object['formLabel']
                ]);
            } else {
                Field::create([
                    'field_name' => $object['field_name'],
                    'type' => $object['type']
                ]);
            }
            $i++;

//            if($i > 10) break;
        }

        $randomRows = Field::inRandomOrder()->take(20)->get();

        foreach ($randomRows as $row) {
            $row->field_category_id = random_int(1, 4);
            $row->save();
        }


    }
}
