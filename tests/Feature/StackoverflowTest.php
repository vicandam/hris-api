<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use GuzzleHttp;

class StackoverflowTest extends TestCase
{

    /**
     * @test
     *
     * ./vendor/bin/phpunit --filter=test_get_stackoverflow_user_answers tests/Feature/StackoverflowTest.php
     */

    public function test_get_stackoverflow_user_answers() {
        $data = [];

        $client = new GuzzleHttp\Client();

        $apiUrl = 'https://api.stackexchange.com/2.2/users/4551227/answers?page=1&pagesize=1&order=desc&sort=activity&site=stackoverflow&key=ABzCprcQclSa7Jcu5fFuKw((';

        // Get all the users top answers
        $res = $client->get(
            $apiUrl,
            [
                'auth' => [
                    'mrjesuserwinsuarez@gmail.com',
                    'replacement1'
                ]
            ]
        );

        $content = $res->getBody();

        $topAnswers = json_decode($content, true)['items'];

        // Get the specific quertion and answer
        foreach($topAnswers as $index => $item) {
            $question_id = $item['question_id'];
            $answer_id = $item['answer_id'];

            // get the main entry
            $data[$index]['entry'] =  $item;

            // get thequestion
            $questionUrl = 'https://api.stackexchange.com/2.2/questions/' . $question_id . '?&site=stackoverflow&filter=withbody&key=ABzCprcQclSa7Jcu5fFuKw((';

            $res = $client->get($questionUrl);

            $content = $res->getBody();

            $questions = json_decode($content, true);

            $question = array_first($questions['items']);

            $data[$index]['question'] = $question;

            // get the answer
            $answerUrl = 'https://api.stackexchange.com/2.2/answers/' . $answer_id . '?&site=stackoverflow&filter=withbody&key=ABzCprcQclSa7Jcu5fFuKw((';

            $res = $client->get($answerUrl);

            $content = $res->getBody();

            $answers = json_decode($content, true);

            $answer = array_first($answers['items']);

            $data[$index]['answer'] = $answer;
        }

        // print_r($data);

        $quest_id1 = $data[0]['entry']['question_id'];
        $quest_id2 = $data[0]['question']['question_id'];

        $answer_id1 = $data[0]['entry']['answer_id'];
        $answer_id2 = $data[0]['answer']['answer_id'];

        // check if the response is correct
        $this->assertTrue(($quest_id1 == $quest_id2) && ($answer_id1 == $answer_id2));

        // status should be 200
        $this->assertTrue($res->getStatusCode() == 200);

    }


    /*
     * @test
     * ./vendor/bin/phpunit --filter test_get_stackoveflow_question_and_answer_from_controller tests/Feature/StackoverflowTest.php
     */
    public function test_get_stackoveflow_question_and_answer_from_controller()
    {
        $data = [
            'limit' => 5,
            'offset' => 1,
            'stack_overflow_user_id' => 4551227,
            'stack_overflow_api_key' => 'ABzCprcQclSa7Jcu5fFuKw(('
        ];

        // http request
        $response = $this->post('api/external/stackoverflow-question-and-answer', $data);

        // check the result if does match

        // check if found the new contact send
        $original = $response->original;

        // print_r($original);

        $quest_id1 = $original['data']['question_and_answer'][0]['entry']['question_id'];
        $quest_id2 = $original['data']['question_and_answer'][0]['question']['question_id'];

        $answer_id1 = $original['data']['question_and_answer'][0]['entry']['answer_id'];
        $answer_id2 =  $original['data']['question_and_answer'][0]['answer']['answer_id'];



        // check if the response is correct
        $this->assertTrue(($quest_id1 == $quest_id2) && ($answer_id1 == $answer_id2));

        // check the response status
        $response->assertStatus(200);

    }

    /*
     * @test
     * ./vendor/bin/phpunit --filter test_get_my_answers tests/Feature/StackoverflowTest.php
     */
    public function test_get_my_answers_and_question_from_actual_api() {

        $data = [];

        $client = new GuzzleHttp\Client();

        $apiUrl = 'https://api.stackexchange.com/2.2/users/4551227/tags/laravel/top-answers?page=1&pagesize=10&order=asc&sort=activity&site=stackoverflow&key=ABzCprcQclSa7Jcu5fFuKw((';

        // Get all the users top answers
        $res = $client->get(
            $apiUrl,
            [
                'auth' => [
                    'mrjesuserwinsuarez@gmail.com',
                    'replacement1'
                ]
            ]
        );

        $content = $res->getBody();

        $topAnswers = json_decode($content, true)['items'];

        // Get the specific quertion and answer
        foreach($topAnswers as $index => $item) {
            $question_id = $item['question_id'];
            $answer_id = $item['answer_id'];

            // get the main entry
            $data[$index]['entry'] =  $item;

            // get thequestion
            $questionUrl = 'https://api.stackexchange.com/2.2/questions/' . $question_id . '?&site=stackoverflow&filter=withbody&key=ABzCprcQclSa7Jcu5fFuKw((';

            $res = $client->get($questionUrl);

            $content = $res->getBody();

            $questions = json_decode($content, true);

            $question = array_first($questions['items']);

            $data[$index]['question'] = $question;

            // get the answer
            $answerUrl = 'https://api.stackexchange.com/2.2/answers/' . $answer_id . '?&site=stackoverflow&filter=withbody&key=ABzCprcQclSa7Jcu5fFuKw((';

            $res = $client->get($answerUrl);

            $content = $res->getBody();

            $answers = json_decode($content, true);

            $answer = array_first($answers['items']);

            $data[$index]['answer'] = $answer;
        }

        //print_r($data);


        $quest_id1 = $data[0]['entry']['question_id'];
        $quest_id2 = $data[0]['question']['question_id'];

        $answer_id1 = $data[0]['entry']['answer_id'];
        $answer_id2 = $data[0]['answer']['answer_id'];


        // check if the response is correct
        $this->assertTrue(($quest_id1 == $quest_id2) && ($answer_id1 == $answer_id2));

        // status should be 200
        $this->assertTrue($res->getStatusCode() == 200);
    }

    /*
     * @test
     * ./vendor/bin/phpunit --filter test_load_more_answers tests/Feature/StackoverflowTest.php
     */
    public function test_load_more_answers()
    {
        $this->assertTrue(true);
    }
}
