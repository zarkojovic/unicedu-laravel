<?php

namespace Database\Seeders;

use App\Models\Field;
use App\Models\FieldItem;
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

        // Path to the public/js directory
        $jsPath = resource_path('js');

        file_put_contents($jsPath . "/fields.json", $json);
        $i = 0;
        $hiddenFields = array();
        foreach ($arrayOfObjects as $object) {
            if (isset($object['formLabel'])) {
                Field::create([
                    'field_name' => $object['field_name'],
                    'type' => $object['type'],
                    'title' => $object['formLabel']
                ]);
            } else {
                $i++;
                $hiddenFields[] = [
                    "field_name" => $object['field_name'],
                    "is_required" => '0',
                    'order' => $i,
                    "field_category_id" => '5'
                ];
                Field::create([
                    'field_name' => $object['field_name'],
                    'type' => $object['type']
                ]);
            }

        }

        $personalCategory = [
            [
                "field_name" => 'UF_CRM_1667334040534',
                "is_required" => '1',
                "order" => '3',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1680032383794',
                "is_required" => '1',
                "order" => '1',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1680298400987',
                "is_required" => '1',
                "order" => '2',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1683816608395',
                "is_required" => '0',
                "order" => '4',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1683816650459',
                "is_required" => '0',
                "order" => '5',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1683816660119',
                "is_required" => '0',
                "order" => '6',
                "field_category_id" => '1'
            ],
            [
                "field_name" => 'UF_CRM_1683816693121',
                "is_required" => '0',
                "order" => '7',
                "field_category_id" => '1'
            ],

        ];

        $addressCategory = [
            [
                "field_name" => 'UF_CRM_1680032015767',
                "is_required" => '0',
                "order" => '1',
                "field_category_id" => '2'
            ],
            [
                "field_name" => 'UF_CRM_1680032052359',
                "is_required" => '0',
                "order" => '2',
                "field_category_id" => '2'
            ],
            [
                "field_name" => 'UF_CRM_1680032063562',
                "is_required" => '0',
                "order" => '3',
                "field_category_id" => '2'
            ],
            [
                "field_name" => 'UF_CRM_1680032097700',
                "is_required" => '0',
                "order" => '4',
                "field_category_id" => '2'
            ],
            [
                "field_name" => 'UF_CRM_1680032106247',
                "is_required" => '0',
                "order" => '5',
                "field_category_id" => '2'
            ],
            [
                "field_name" => 'UF_CRM_1680032120828',
                "is_required" => '0',
                "order" => '6',
                "field_category_id" => '2'
            ]
        ];

        $documentsCategory = [
            [
                "field_name" => 'UF_CRM_1668771731749',
                "is_required" => '0',
                "order" => '1',
                "field_category_id" => '3'
            ],
            [
                "field_name" => 'UF_CRM_1668771824662',
                "is_required" => '0',
                "order" => '2',
                "field_category_id" => '3'
            ],
            [
                "field_name" => 'UF_CRM_1668771835309',
                "is_required" => '0',
                "order" => '3',
                "field_category_id" => '3'
            ],
            [
                "field_name" => 'UF_CRM_1668771849100',
                "is_required" => '0',
                "order" => '4',
                "field_category_id" => '3'
            ],
            [
                "field_name" => 'UF_CRM_1668771875508',
                "is_required" => '0',
                "order" => '5',
                "field_category_id" => '3'
            ]
        ];

        $dealsCategory = [
            [
                "field_name" => 'UF_CRM_1667335624051',
                "is_required" => '0',
                "order" => '3',
                "field_category_id" => '4'
            ],
            [
                "field_name" => 'UF_CRM_1667335695035',
                "is_required" => '0',
                "order" => '4',
                "field_category_id" => '4'
            ],
            [
                "field_name" => 'UF_CRM_1667335742921',
                "is_required" => '0',
                "order" => '1',
                "field_category_id" => '4'
            ],
            [
                "field_name" => 'UF_CRM_1668001651504',
                "is_required" => '0',
                "order" => '2',
                "field_category_id" => '4'
            ]
        ];

        $i++;
        $hiddenCategory = [
            [
                "field_name" => 'UF_CRM_1667336320092',
                "is_required" => '1',
                'order' => $i,
                "field_category_id" => '5'
            ]
        ];
        $hiddenCategory = array_merge($hiddenCategory, $hiddenFields);

        $allCategories = [$personalCategory, $addressCategory, $documentsCategory, $dealsCategory, $hiddenCategory];

        foreach ($allCategories as $category) {

            foreach ($category as $item) {
                $row = Field::where('field_name', $item["field_name"])->first();
                $row->field_category_id = $item["field_category_id"];
                $row->is_required = $item["is_required"];
                if (isset($item["order"])) {
                    $row->order = $item["order"];
                }
                $row->save();
            }

        }




    }
}
