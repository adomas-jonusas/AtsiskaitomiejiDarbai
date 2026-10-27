<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LayoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_uses_the_configured_name_and_blade_footer(): void
    {
        $this->get('/')
            ->assertOk()
            ->assertSee('Chirper – Adomas Jonušas')
            ->assertSee('Sukūrė: Adomas Jonušas | 3PHP-1')
            ->assertSee('text-blue-700');
    }
}
