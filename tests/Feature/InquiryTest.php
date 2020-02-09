<?php

namespace Tests\Feature;

use App\Inuquiries;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class InquiryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function test_submit_inquiry()
    {
        $attributes = [
            'name'    => 'James Doe',
            'email'   => 'test@gmail.com',
            'message' => 'Hello World',
            'testing' => 1
        ];

        $response = $this->post('inquiries', $attributes);

        $response->assertOk();

        $data = $response->getOriginalContent();

        $this->assertEquals('Success', $data['message']);
    }
}
