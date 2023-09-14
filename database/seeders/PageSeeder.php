<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $pages = [
            [
                'route' => '/dashboard',
                'title' => 'Dashboard',
                'icon' => 'ti ti-dashboard',
                'role_id' => '3',
                'is_editable' => false
            ],
            [
                'route' => '/profile',
                'title' => 'My Information',
                'icon' => 'ti ti-user',
                'role_id' => '1',
                'is_editable' => false
            ], [
                'route' => '/pages',
                'title' => 'Pages',
                'icon' => 'ti ti-wallpaper',
                'role_id' => '3',
                'is_editable' => false
            ], [
                'route' => '/categories',
                'title' => 'Categories',
                'icon' => 'ti ti-box-multiple',
                'role_id' => '3',
                'is_editable' => false
            ], [
                'route' => '/fields',
                'title' => 'Fields',
                'icon' => 'ti ti-row-insert-top',
                'role_id' => '3',
                'is_editable' => false
            ], [
                'route' => '/users',
                'title' => 'Users',
                'icon' => 'ti ti-users',
                'role_id' => '3',
                'is_editable' => false
            ], [
                'route' => '/applications',
                'title' => 'Applications',
                'icon' => 'ti ti-school',
                'role_id' => '1',
                'is_editable' => false
            ], [
                'route' => '/applications',
                'title' => 'Applications',
                'icon' => 'ti ti-api-app',
                'role_id' => '3',
                'is_editable' => false
            ]
        ];

        foreach ($pages as $page) {

            $new = new Page();
            $new->route = $page['route'];
            $new->title = $page['title'];
            $new->icon = $page['icon'];
            $new->is_editable = $page['is_editable'];
            $new->role_id = $page['role_id'];

            $new->save();

            if ($page['route'] == '/profile') {

                $ids = ['1', '2', '3'];
                foreach ($ids as $id) {
                    DB::table('field_category_page')->insert([
                        'field_category_id' => $id,
                        'page_id' => $new->page_id,
                    ]);
                }
            }

        }

    }
}
