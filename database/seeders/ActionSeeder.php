<?php

namespace Database\Seeders;

use App\Models\Action;
use Illuminate\Database\Seeder;

class ActionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $action_names = ['auth', 'information', 'errors', 'api'];

        foreach ($action_names as $action_name) {
            $action = Action::create([
                'action_name' => $action_name
            ]);
        }
    }
}
