<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class APIServersTest extends TestCase
{
    /**
     * A basic API existence test
     *
     * @return void
     */
    public function test_if_api_is_responding()
    {
        $response = $this->get(route('servers.index'));

        $response->assertStatus(200);
    }

    /**
     * Checks if it can retrieve the server list
     *
     * @return void
     */
    public function test_if_api_is_returning_a_list_of_servers()
    {
        $this->withoutExceptionHandling();

        $response = $this->getJson(route('servers.index'));

        $this->assertEquals(true, $response->json('status'));
    }

}
