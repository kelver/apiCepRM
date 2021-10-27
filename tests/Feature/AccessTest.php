<?php

namespace Tests\Feature;

use Tests\TestCase;

class AccessTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_access_to_api()
    {
        $response = $this->get('/api');

        $response->assertStatus(200);
    }

    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_api_json_return()
    {
        $response = $this->get('/api/cep/78088000');

        $response->assertJsonCount(1);
    }
}
