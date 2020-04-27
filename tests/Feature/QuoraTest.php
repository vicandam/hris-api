<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp;



class QuoraTest extends TestCase
{
    /**.
     * @test
     *
     * ./vendor/bin/phpunit --filter test_get_my_answers tests/Feature/QuoraTest.php
     */
    //    public function test_get_my_answers()
    //    {
    //        $client = new GuzzleHttp\Client();
    //
    //        $apiUrl = 'http://quora.christopher.su/users/Aaron-Ounn/activity/review_requests';
    //
    //
    //        $this->assertTrue(true);
    //
    //        $res = $client->get($apiUrl);
    //
    //        $content = $res->getBody();
    //
    //        $topAnswers = json_decode($content, true);
    //
    //        dd($topAnswers);
    //    }





    /**
     * @test
     *
     * sampleTest
     */

    public function test_sample_test() {
        $this->assertTrue(true);
    }
}
