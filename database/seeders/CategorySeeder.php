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
        // Sample categories data with IDs
        $categories = [
            ['id' => 1, 'name' => 'Foods'],
            ['id' => 2, 'name' => 'Plants'],
            ['id' => 3, 'name' => 'Garden n Farming'],
            ['id' => 4, 'name' => 'Animals'],
            ['id' => 5, 'name' => 'For house n apartment'],
            ['id' => 6, 'name' => 'Clothes'],
            ['id' => 7, 'name' => 'Arms n weapons'],
            ['id' => 8, 'name' => 'Furniture'],
            ['id' => 9, 'name' => 'Technique'],
            ['id' => 10, 'name' => 'Transport'],
            ['id' => 11, 'name' => 'E-goods'],
            ['id' => 12, 'name' => 'Medicine'],
            ['id' => 13, 'name' => 'Jobs n Staff'],
            ['id' => 14, 'name' => 'Sports'],
            ['id' => 15, 'name' => 'Toys n kids'],
            ['id' => 16, 'name' => 'Freebies'],
            ['id' => 17, 'name' => 'Hobbies'],
            ['id' => 18, 'name' => 'Estate'],
            ['id' => 19, 'name' => 'For bussiness n office'],
            ['id' => 20, 'name' => 'Tools and apparutara'],
        ];

        // Inserting sample data into the categories table
        DB::table('categories')->insert($categories);
    }
}
