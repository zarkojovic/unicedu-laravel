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
                'route' => '/profile',
                'title' => 'My Information',
                'icon' => 'ti ti-user',
                'role_id' => '1'
            ], [
                'route' => '/pages',
                'title' => 'Pages',
                'icon' => 'ti ti-wallpaper',
                'role_id' => '3'
            ], [
                'route' => '/categories',
                'title' => 'Categories',
                'icon' => 'ti ti-box-multiple',
                'role_id' => '3'
            ], [
                'route' => '/fields',
                'title' => 'Fields',
                'icon' => 'ti ti-row-insert-top',
                'role_id' => '3'
            ], [
                'route' => '/users',
                'title' => 'Users',
                'icon' => 'ti ti-users',
                'role_id' => '3'
            ],
        ];

        foreach ($pages as $page) {

            $new = new Page();
            $new->route = $page['route'];
            $new->title = $page['title'];
            $new->icon = $page['icon'];
            $new->role_id = $page['role_id'];

            $new->save();

            if ($page['route'] == '/profile') {

                $ids = ['1', '2', '3', '4'];
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
