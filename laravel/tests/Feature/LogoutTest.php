<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LogoutTest extends TestCase
{
    use RefreshDatabase;

    public function test_logout_ends_authentication_clears_the_session_and_renews_csrf_token(): void
    {
        $this->actingAs(User::factory()->create());

        $this->withSession(['marker' => 'private-data', '_token' => 'old-token'])
            ->post('/logout')->assertRedirect('/')
            ->assertSessionMissing('marker')->assertSessionHas('_token');

        $this->assertGuest();
        $this->assertNotSame('old-token', session()->token());
        $this->get('/')->assertSee('Prisijungti')->assertDontSee('Atsijungti');
        $this->post('/chirps', ['message' => 'Po atsijungimo'])->assertRedirect('/login');
    }

    public function test_logout_requires_authentication_and_a_post_request(): void
    {
        $this->post('/logout')->assertRedirect('/login');
        $this->get('/logout')->assertStatus(405);
    }
}
