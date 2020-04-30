<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'name' => 'عباية خروج',
            'image' => 'default_category.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'عباية خليجي',
            'image' => 'default_category.png'
        ]);

        DB::table('categories')->insert([
            'name' => 'عباية تركي',
            'image' => 'default_category.png'
        ]);
    }
}
