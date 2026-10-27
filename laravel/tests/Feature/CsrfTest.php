<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CsrfTest extends TestCase
{
    use RefreshDatabase;

    public function test_auth_forms_reject_requests_without_a_csrf_token(): void
    {
        // Įprastai Laravel testų aplinkoje CSRF tikrinimą praleidžia.
        $this->app->instance('env', 'local');

        $this->post('/login', ['email' => 'csrf@example.test', 'password' => 'bandymas'])->assertStatus(419);
        $this->post('/register', ['name' => 'Bandymas'])->assertStatus(419);
        $this->assertDatabaseCount('users', 0);
    }

    public function test_registration_accepts_a_matching_session_token(): void
    {
        $this->app->instance('env', 'local');

        $this->withSession(['_token' => 'matching-test-token'])->post('/register', [
            '_token' => 'matching-test-token',
            'name' => 'CSRF bandymas',
            'email' => 'csrf@example.test',
            'password' => 'bandymo-slaptazodis',
            'password_confirmation' => 'bandymo-slaptazodis',
        ])->assertRedirect('/');

        $this->assertAuthenticated();
    }
}
