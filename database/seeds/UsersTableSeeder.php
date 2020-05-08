<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('users')->truncate();

        $users = factory(User::class, 5)->create();

        foreach ($users as $key => $user) {

            if ($key > 3) {
                $user->assignRole('admin');
            } else {
                $user->assignRole('employee');
            }
        }
    }
}
