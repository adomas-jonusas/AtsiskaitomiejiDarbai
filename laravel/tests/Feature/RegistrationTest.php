<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function test_registration_page_uses_the_shared_footer(): void
    {
        $this->get('/register')->assertOk()->assertSee('Sukūrė: Adomas Jonušas | 3PHP-1');
    }

    public function test_registration_creates_a_user_hashes_the_password_and_logs_in(): void
    {
        $this->post('/register', [
            'name' => 'Bandymo vartotojas',
            'email' => 'register@example.test',
            'password' => 'bandymo-slaptazodis',
            'password_confirmation' => 'bandymo-slaptazodis',
        ])->assertRedirect('/');

        $user = User::where('email', 'register@example.test')->firstOrFail();
        $this->assertAuthenticatedAs($user);
        $this->assertTrue(Hash::check('bandymo-slaptazodis', $user->password));
        $this->assertNotSame('bandymo-slaptazodis', $user->password);
    }

    public function test_registration_rejects_invalid_fields(): void
    {
        $this->post('/register', [
            'name' => '', 'email' => 'neteisingas',
            'password' => 'short', 'password_confirmation' => 'kitas',
        ])->assertSessionHasErrors(['name', 'email', 'password']);

        $this->assertDatabaseCount('users', 0);
        $this->assertGuest();
    }

    public function test_duplicate_email_is_rejected(): void
    {
        User::factory()->create(['email' => 'exists@example.test']);

        $this->post('/register', [
            'name' => 'Kitas vartotojas', 'email' => 'exists@example.test',
            'password' => 'bandymo-slaptazodis', 'password_confirmation' => 'bandymo-slaptazodis',
        ])->assertSessionHasErrors('email');

        $this->assertDatabaseCount('users', 1);
    }
}
