<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('categories')->insert([
            'category_name' => 'PHP',
        ]);
        DB::table('categories')->insert([
            'category_name' => 'Javascript',
        ]);
        DB::table('categories')->insert([
            'category_name' => 'CSS',
        ]);
    }
}
