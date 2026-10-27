<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class CreateChirpTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();
        $this->actingAs(User::factory()->create());
    }

    public function test_a_chirp_is_stored_and_shown_in_the_feed(): void
    {
        $this->post('/chirps', ['message' => 'Mano nauja žinutė'])
            ->assertRedirect('/')->assertSessionHas('success');

        $this->assertDatabaseHas('chirps', ['message' => 'Mano nauja žinutė']);
        $this->get('/')->assertSee('Mano nauja žinutė');
    }

    public function test_empty_and_whitespace_messages_are_rejected(): void
    {
        foreach (['', '   '] as $message) {
            $this->from('/')->post('/chirps', ['message' => $message])
                ->assertRedirect('/')->assertSessionHasErrors('message');
        }

        $this->assertDatabaseCount('chirps', 0);
    }

    public function test_messages_longer_than_255_characters_are_rejected_and_preserved(): void
    {
        $message = str_repeat('ą', 256);

        $this->from('/')->post('/chirps', ['message' => $message])
            ->assertRedirect('/')->assertSessionHasErrors('message')
            ->assertSessionHasInput('message', $message);

        $this->assertDatabaseCount('chirps', 0);
        $this->get('/')->assertSee('gali būti iki 255 simbolių.');
    }

    public function test_a_255_character_message_is_accepted(): void
    {
        $message = str_repeat('ą', 255);

        $this->post('/chirps', ['message' => $message])->assertRedirect('/');

        $this->assertDatabaseHas('chirps', ['message' => $message]);
    }

    public function test_messages_are_escaped_by_blade(): void
    {
        $message = '<script>alert("test")</script>';
        $this->post('/chirps', ['message' => $message])->assertRedirect('/');

        $this->get('/')->assertSee($message)->assertDontSee($message, false);
    }
}
