<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testNotFoundRoute()
    {
        $response = $this->get('/not-found');
        $response->assertStatus(404);
    }
}
