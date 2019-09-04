<?php

use Illuminate\Database\Seeder;
use App\Category;

class CategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('categories')->truncate();

        $categories = [
            [
                'name' => 'Select category'
            ],
            [
                'name' => 'Laravel'
            ],
            [
                'name' => 'Laravel Fix'
            ],
            [
                'name' => 'Laravel package development'
            ],
            [
                'name' => 'Laravel Feature development'
            ],
            [
                'name' => 'Laravel package customization'
            ],
            [
                'name' => 'Laravel Maintenance'
            ],
            [
                'name' => 'Laravel Development'
            ],
            [
                'name' => 'PHP development'
            ],
            [
                'name' => 'PHP fix'
            ],
            [
                'name' => 'PHP Maintenance'
            ],
            [
                'name' => 'Web Consultation'
            ],
            [
                'name' => 'Quick fix'
            ],
            [
                'name' => 'Personal Assistance'
            ],
            [
                'name' => 'Feedback'
            ],
            [
                'name' => 'Others'
            ],
        ];

        foreach ($categories as $category) {
            Category::UpdateOrCreate(['name' => $category['name']], $category);
        }
    }
}
