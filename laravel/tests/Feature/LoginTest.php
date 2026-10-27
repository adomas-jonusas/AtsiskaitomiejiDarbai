<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class LoginTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_uses_the_shared_footer(): void
    {
        $this->get('/login')->assertOk()->assertSee('Sukūrė: Adomas Jonušas | 3PHP-1');
    }

    public function test_a_user_can_log_in_and_be_remembered(): void
    {
        $user = User::factory()->create(['password' => 'bandymo-slaptazodis']);

        $this->post('/login', ['email' => $user->email, 'password' => 'bandymo-slaptazodis', 'remember' => '1'])
            ->assertRedirect('/');

        $this->assertAuthenticatedAs($user);
        $this->assertNotNull($user->fresh()->remember_token);
    }

    public function test_invalid_credentials_are_rejected_without_flashing_the_password(): void
    {
        $user = User::factory()->create();

        $this->from('/login')->post('/login', ['email' => $user->email, 'password' => 'neteisingas'])
            ->assertRedirect('/login')->assertSessionHasErrors('email')
            ->assertSessionHasInput('email', $user->email)->assertSessionMissing('_old_input.password');

        $this->assertGuest();
    }

    public function test_login_returns_to_the_intended_edit_page(): void
    {
        $user = User::factory()->create(['password' => 'bandymo-slaptazodis']);
        $chirp = $user->chirps()->create(['message' => 'Mano žinutė']);
        $path = '/chirps/'.$chirp->id.'/edit';
        $this->get($path)->assertRedirect('/login');

        $this->post('/login', ['email' => $user->email, 'password' => 'bandymo-slaptazodis'])
            ->assertRedirect($path);
    }

    public function test_authenticated_users_are_redirected_from_guest_pages(): void
    {
        $this->actingAs(User::factory()->create());

        $this->get('/login')->assertRedirect('/');
        $this->get('/register')->assertRedirect('/');
    }
}
