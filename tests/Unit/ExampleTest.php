<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ExampleTest extends TestCase
{
    /**
     * A basic test example.
     *
     * @return void
     */
    public function testBasicTest()
    {
        $this->assertTrue(true);
    }

    public function soccerEditAuthenticated()
    {

        $response = $this->get('/boys-soccer/3/edit');

        $response->assertStatus(403);

    }
}
