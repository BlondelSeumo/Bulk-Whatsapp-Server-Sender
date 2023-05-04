<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Menu;
class MenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Menu::create([
            'name' => 'Header',
            'position' => 'main-menu',
            'data' => '[{"text":"Home","icon":"","href":"/","target":"_self","title":""},{"text":"Pricing","icon":"empty","href":"/pricing","target":"_self","title":""},{"text":"About","icon":"empty","href":"/about","target":"_self","title":""},{"text":"Features","icon":"empty","href":"/features","target":"_self","title":""},{"text":"Blogs","icon":"empty","href":"/blogs","target":"_self","title":""},{"text":"Contact","icon":"empty","href":"/contact","target":"_self","title":""}]',
            'lang' => 'en',
            'status' => 1
        ]);
    }
}
