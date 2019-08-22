<?php

namespace Tests\Feature;

use App\Interaction;
//use Illuminate\Foundation\Testing\DatabaseMigrations;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Post;
use App\User;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class AuthTest extends TestCase
{
    public function test_test() {
        $this->assertTrue(true);
    }
}