<?php

namespace Tests\Feature;

// use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Service;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthAdminTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function admin(): void
    {
        auth()->loginUsingId(1);
        $this->get('/admin')->assertStatus(200);
        $this->get('/admin/disk-usages')->assertStatus(200);
    }

}
