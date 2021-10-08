<?php

namespace Tests\Unit;


use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

// use PHPUnit\Framework\TestCase;
use Tests\TestCase;

class ClimaTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function test_Clima()
    {
        $response = $this->get('/api/clima');

        $response->assertStatus(200);
    }

    public function test_Clima_cidade()
        {
            $response = $this->json('GET', '/api/clima/Florianopolis');

            $response->assertStatus(200);
        }
}
