<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use App\User;
use App\Message;

class MessageTest extends TestCase
{

    /**
     * @test
     *
     *
     * ./vendor/bin/phpunit --filter test_load_feedback_only tests/Feature/MessageTest.php
     */
    public function test_load_feedback_only()
    {

        $recipient = factory(User::class)->create();

        // delete first all the messages
        Message::whereNotNull('id')->delete();


        factory(Message::class, 5)->create([
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ]);


        factory(Message::class, 5)->create([
            'recipient_id' => $recipient->id,
            'type' => 'contact'
        ]);


        // set data
        $data = [
            'offset' => 0,
            'limit' => 100,
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ];


        // trigger url
        $response = $this->post('api/message/feedback/search', $data);


        $original = $response->original;

        $this->assertEquals(
            5,
            count($original['data']['feedbacks'])
        );

    }

    /*
     * @test
     * ./vendor/bin/phpunit --filter test_send_contact tests/Feature/MessageTest.php
     */
    public function test_send_contact() {
        // set data
        $data = [
            'name' => 'Jesus',
            'email' => 'mrjesuserwinsuarez@gmail.com',
            'message' => 'Hi, I would like to invite into my job and please apply.',
            'skype_id' => 'jesus.erwin.suarez143',
            'recipient_id' => 1,
            'section' => 'contact',
            'type' => 'contact'
        ];

        // trigger url
        $response = $this->post('api/message1/contact1', $data);

        // check if found the new contact send
        $original = $response->original;

        $message1 = $data['message'];
        $message2 = $original['data']['contact']['message'];
        $id = $original['data']['contact']['id'];

        $this->assertTrue($message1 == $message2 && $id > 0);

        // check if status 200
        $response->assertStatus(200);
    }

    /*
       * @test
       * ./vendor/bin/phpunit --filter test_post_new_feedback tests/Feature/MessageTest.php
       */
    public function test_post_new_feedback() {
        $recipient = factory(User::class)->create();

        // set data
        $data = [
            'email' => 'vicajobs@gmail.com',
            'name' => 'Vic Datu Andam',
            'project_name' => 'Laravel development',
            'message' => 'Hi, I would like to invite into my job and please apply.',
            'recipient_id' => $recipient->id,
            'section' => 'post feedback'
        ];

        // trigger url
        $response = $this->post('api/message/feedback', $data);

        // check if found the new contact send
        $original = $response->original;

        $message1 = $data['message'];
        $message2 = $original['data']['feedback']['message'];
        $id = $original['data']['feedback']['id'];

        $this->assertTrue($message1 == $message2 && $id > 0);

        // check if status 200
        $response->assertStatus(200);
    }

    /*
    * @test
    * ./vendor/bin/phpunit --filter test_delete_feedback tests/Feature/MessageTest.php
    */
    public function test_delete_feedback() {
        // create feedback
        $feedback = factory(Message::class)->create();

        // trigger url
        $response = $this->post('api/message/feedback/' . $feedback->id . '/delete');

        // check if found the new contact send
        $original = $response->original;

        $deleted = $original['data']['deleted'];

        $this->assertTrue($deleted);

        // check if status 200
        $response->assertStatus(200);
    }

    /*
    * @test
    * ./vendor/bin/phpunit --filter test_load_more_feedback tests/Feature/MessageTest.php
    */
    public function test_load_more_feedback() {
        $recipient = factory(User::class)->create();

        factory(Message::class, 30)->create([
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ]);

        // set data
        $data = [
            'offset' => 0,
            'limit' => 5,
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ];

        // trigger url
        $response1 = $this->post('api/message/feedback/search', $data);

        // set data
        $data = [
            'offset' => 5,
            'limit' => 5,
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ];

        // trigger url
        $response2 = $this->post('api/message/feedback/search', $data);

        // set data
        $data = [
            'offset' => 10,
            'limit' => 5,
            'recipient_id' => $recipient->id,
            'type' => 'feedback'
        ];

        // trigger url
        $response3 = $this->post('api/message/feedback/search', $data);

        $original1 = $response1->original;
        $original2 = $response2->original;
        $original3 = $response3->original;

        $message1 = $original1['data']['feedbacks'][0]['message'];
        $message2 = $original2['data']['feedbacks'][0]['message'];
        $message3 = $original3['data']['feedbacks'][0]['message'];
        // check if 1, 2 and 3 are not the same

        $this->assertTrue(($message1 != $message2) && ($message2 != $message3));

        // check status 1, 2, 3 responses
        $response1->assertStatus(200);
        $response2->assertStatus(200);
        $response3->assertStatus(200);
    }
}
