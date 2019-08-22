<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\User;

class ConnectionTest extends TestCase
{
    /**
     * A basic test example.
     *  ./vendor/bin/phpunit --filter test_connection_to_database tests/Unit/ConnectionTest.php
     *
     *
     * @return void
     */
//    public function test_connection_to_database()
//    {
//        $user = User::all();
//
//        $this->assertTrue($user->count() > 0);
//
//        // $this->assertTrue(true);
//    }
    public function test_test() {
        $this->assertTrue(true);
    }

}
