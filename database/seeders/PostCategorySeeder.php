<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Postcategory;
class PostCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $postcategories = array(
          array('post_id' => '8','category_id' => '7'),
          array('post_id' => '8','category_id' => '13'),
          array('post_id' => '9','category_id' => '7'),
          array('post_id' => '9','category_id' => '8'),
          array('post_id' => '9','category_id' => '12'),
          array('post_id' => '9','category_id' => '13'),
          array('post_id' => '10','category_id' => '6'),
          array('post_id' => '10','category_id' => '13'),
          array('post_id' => '10','category_id' => '14')
        );

        Postcategory::insert($postcategories);

    }
}
