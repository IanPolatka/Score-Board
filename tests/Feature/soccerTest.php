<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\RefreshDatabase;

class soccerTest extends TestCase
{
    /** @test **/
    public function soccerEditAuthenticated()
    {

        $response = $this->get('/boys-soccer/3/edit');

        $response->assertStatus(403);

    }
}
