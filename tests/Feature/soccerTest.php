<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class soccerTest extends TestCase
{
    /** @test **/
    public function soccerEditAuthenticated()
    {
        $response = $this->get('/boys-soccer/3/edit');

        $response->assertStatus(403);
    }
}
