<?php

use Illuminate\Database\Seeder;
use App\Attendance;

date_default_timezone_set('Asia/Manila');

class AttendanceTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(Attendance::class)->create();
    }
}
