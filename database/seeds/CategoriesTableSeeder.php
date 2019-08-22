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
        $categories = [
            [
                'name' => 'Select category'
            ],
            [
                'name' => 'Web Development'
            ],
            [
                'name' => 'Web Services'
            ],
            [
                'name' => 'Wordpress'
            ],
            [
                'name' => 'Wordpress Fix'
            ],
            [
                'name' => 'Wordpress plugin development'
            ],
            [
                'name' => 'Wordpress plugin customization'
            ],
            [
                'name' => 'Wordpress theme customization'
            ],
            [
                'name' => 'Wordpress theme development'
            ],
            [
                'name' => 'Wordpress Development'
            ],
            [
                'name' => 'Wordpress Maintenance'
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
                'name' => 'Shopify customization'
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
