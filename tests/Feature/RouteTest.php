<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RouteTest extends TestCase
{
    /** @test */
    public function main(): void
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    /** @test */
    public function admin(): void
    {
        $response = $this->get('/admin');
        $response->assertStatus(302);
    }

    /** @test */
    public function login(): void
    {
        $response = $this->get('/admin/login');
        $response->assertStatus(200);
    }

}
