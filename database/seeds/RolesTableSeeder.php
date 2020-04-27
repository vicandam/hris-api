<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        DB::table('roles')->truncate();

        factory(Role::class)->create(['guard_name' => 'web', 'name' => 'admin']);
        factory(Role::class)->create(['guard_name' => 'web', 'name' => 'employee']);
    }
}
