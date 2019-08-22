<?php

use Illuminate\Database\Seeder;

class MessagesSeederTable extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\Message::class, 40)->create();

    }
}
