<?php

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        // Get all subcategories
        $subcategories = App\Models\Subcategory::all();

        // Iterate through each subcategory
        foreach ($subcategories as $subcategory) {
            // Check if the subcategory has less than 2 products
            if ($subcategory->products->count() < 2) {
                // Generate additional products until there are at least 2
                for ($i = $subcategory->products->count(); $i < 2; $i++) {
                    DB::table('products')->insert([
                        'name' => $faker->word,
                        'description' => $faker->sentence,
                        'price' => $faker->randomFloat(2, 10, 1000), // Adjust the price range as needed
                        'subcategory_id' => $subcategory->id,
                        'created_at' => now(),
                        'updated_at' => now(),
                    ]);
                }
            }
        }
    }
}
