<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateChirpTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_chirp_is_stored_and_shown_in_the_feed(): void
    {
        $this->post('/chirps', ['message' => 'Mano nauja žinutė'])
            ->assertRedirect('/')->assertSessionHas('success');

        $this->assertDatabaseHas('chirps', ['message' => 'Mano nauja žinutė']);
        $this->get('/')->assertSee('Mano nauja žinutė');
    }
}
