<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Message;
use GuzzleHttp;

class GithubTest extends TestCase
{
    /**.
     * @test
     *
     * ./vendor/bin/phpunit --filter test_get_user_repositories_from_controller tests/Feature/GithubTest.php
     */
    public function test_get_user_repositories_from_controller()
    {
        $response = $this->post('api/external/git/repositories', [
            'client_id' => 'Iv1.89ce5c2d0247d74d',
            'client_secret' => '0bb698b88fa3cc690f95d6b714be0f033e5b0240',
            'limit' =>2,
            'offset'=>0
        ]);

        $original = $response->original;

        $repositories = $original['data']['repositories'];

        $name1 = $repositories[0]['full_name'];
        $name2 = $repositories[1]['full_name'];

        echo " \n name1 $name1 name2 $name2";

        $this->assertTrue($name1 !== $name2);

        $response->assertStatus(200);
    }


    /**.
     * @test
     *
     * ./vendor/bin/phpunit --filter test_get_user_information_from_actual_api tests/Feature/GithubTest.php
     */
    public function test_get_user_information_from_actual_api()
    {
        $client_id = 'Iv1.89ce5c2d0247d74d';
        $client_secret = '0bb698b88fa3cc690f95d6b714be0f033e5b0240';

        $client = new GuzzleHttp\Client();

        $apiUrl = "https://api.github.com/users/jesus143?client_id=$client_id&client_secret=$client_secret&order=desc";

        $this->assertTrue(true);

        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $response = json_decode($content, true);

        $name = $response['name'];

        $this->assertEquals('Vic Datu Andam', $name);
    }


    /**
     * @test
     *
     * ./vendor/bin/phpunit --filter test_get_user_repositories_from_actual_api tests/Feature/GithubTest.php
     */
    public function test_get_user_repositories_from_actual_api()
    {
        $client_id = 'Iv1.89ce5c2d0247d74d';
        $client_secret = '0bb698b88fa3cc690f95d6b714be0f033e5b0240';

        $client = new GuzzleHttp\Client();

        $apiUrl = "https://api.github.com/users/jesus143/repos?client_id=$client_id&client_secret=$client_secret";

        $this->assertTrue(true);

        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $response = json_decode($content, true);

        $this->assertTrue(count($response) > 0);
    }

    /**
     * @test
     *
     * ./vendor/bin/phpunit --filter test_get_user_repositories_pagination_load_more_from_actual_api tests/Feature/GithubTest.php
     */
    public function test_get_user_repositories_pagination_load_more_from_actual_api()
    {
        $client_id = 'Iv1.89ce5c2d0247d74d';
        $client_secret = '0bb698b88fa3cc690f95d6b714be0f033e5b0240';

        $client = new GuzzleHttp\Client();

        // page 1
        $page = 1;
        $per_page = 1;

        $apiUrl = "https://api.github.com/users/jesus143/repos?page=$page&per_page=$per_page&client_id=$client_id&client_secret=$client_secret";

        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $response1 = json_decode($content, true);

        // page 2
        $page = 2;
        $per_page = 1;

        $apiUrl = "https://api.github.com/users/jesus143/repos?page=$page&per_page=$per_page&client_id=$client_id&client_secret=$client_secret";

        $res = $client->get($apiUrl);

        $content = $res->getBody();

        $response2 = json_decode($content, true);

        $name1 = $response1[0]['name'];
        $name2 = $response2[0]['name'];

        $this->assertTrue($name1 != $name2);

    }

}
