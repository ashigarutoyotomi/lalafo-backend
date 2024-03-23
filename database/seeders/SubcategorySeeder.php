<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SubcategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {$categories = [
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
        // Sample subcategories data grouped by category
        $subcategories = [
            1 => ['Bakery', 'Dairy Products', 'Fresh Produce', 'Meat and Seafood', 'Canned Goods', 'Beverages', 'Snacks', 'Spices'],
            2 => ['Flowers', 'Trees', 'Shrubs', 'Vegetables', 'Herbs', 'Fruits', 'Indoor Plants', 'Seeds and Bulbs'],
            3 => ['Gardening Tools', 'Fertilizers', 'Pesticides', 'Irrigation Systems', 'Tractors', 'Farm Machinery', 'Greenhouses', 'Landscaping Services'],
            4 => ['Dogs', 'Cats', 'Birds', 'Fish', 'Reptiles', 'Small Mammals', 'Pet Supplies', 'Pet Services'],
            5 => ['Furniture', 'Appliances', 'Home Decor', 'Kitchenware', 'Gardening Tools', 'Home Improvement', 'Lighting', 'Outdoor Furniture'],
            6 => ['Men\'s Clothing', 'Women\'s Clothing', 'Children\'s Clothing', 'Shoes', 'Accessories', 'Underwear', 'Outerwear', 'Sportswear'],
            7 => ['Guns', 'Knives', 'Swords', 'Ammunition', 'Archery Equipment', 'Tactical Gear', 'Protective Gear', 'Training Weapons'],
            8 => ['Living Room Furniture', 'Bedroom Furniture', 'Kitchen Furniture', 'Office Furniture', 'Outdoor Furniture', 'Storage Solutions', 'Tables and Chairs', 'Home Decor'],
            9 => ['Computers', 'Smartphones', 'Tablets', 'Gaming Consoles', 'Home Appliances', 'Audio Equipment', 'TVs', 'Cameras'],
            10 => ['Cars', 'Motorcycles', 'Bicycles', 'Trucks', 'Boats', 'RVs', 'ATVs', 'Scooters'],
            11 => ['Electronics Accessories', 'Home Appliances', 'Gadgets', 'Smart Devices', 'Computers', 'Software', 'Digital Cameras', 'Audio Equipment'],
            12 => ['Prescription Medication', 'Over-the-Counter Medication', 'Medical Supplies', 'Health Supplements', 'Medical Equipment', 'Alternative Medicine', 'First Aid Kits', 'Personal Care Products'],
            13 => ['Full-Time Jobs', 'Part-Time Jobs', 'Freelance Opportunities', 'Internships', 'Temporary Positions', 'Remote Work', 'Contract Jobs', 'Volunteer Work'],
            14 => ['Outdoor Sports', 'Indoor Sports', 'Water Sports', 'Team Sports', 'Individual Sports', 'Fitness Equipment', 'Sportswear', 'Sporting Goods'],
            15 => ['Toys', 'Board Games', 'Puzzles', 'Educational Toys', 'Outdoor Play Equipment', 'Stuffed Animals', 'Dolls', 'Action Figures'],
            16 => ['Free Clothing', 'Free Furniture', 'Free Appliances', 'Free Toys', 'Free Books', 'Free Electronics', 'Free Miscellaneous Items', 'Giveaways'],
            17 => ['Crafting', 'Collecting', 'Painting', 'Drawing', 'Model Building', 'Photography', 'Cooking', 'Gardening'],
            18 => ['Apartments', 'Houses', 'Land', 'Commercial Spaces', 'Vacation Rentals', 'Roommates', 'Property Management', 'Storage Units'],
            19 => ['Office Furniture', 'Office Supplies', 'Business Equipment', 'Commercial Real Estate', 'Business Services', 'Business Opportunities', 'Office Space for Rent', 'Office Space for Sale'],
            20 => ['Hand Tools', 'Power Tools', 'Measuring Tools', 'Tool Storage', 'Construction Equipment', 'Safety Equipment', 'Workshop Machinery', 'Tool Accessories'],
        ];

        // Inserting sample data into the categories and subcategories tables
        foreach ($categories as $category) {
            $categoryId = $category['id'];
            $categoryName = $category['name'];

            // Insert category
            DB::table('categories')->insert([
                'id' => $categoryId,
                'name' => $categoryName,
            ]);

            // Insert subcategories
            foreach ($subcategories[$categoryId] as $subcategoryName) {
                DB::table('subcategories')->insert([
                    'category_id' => $categoryId,
                    'name' => $subcategoryName,
                ]);
            }
        }}
}
