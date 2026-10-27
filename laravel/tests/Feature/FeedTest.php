<?php

namespace Tests\Feature;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FeedTest extends TestCase
{
    use RefreshDatabase;

    public function test_empty_feed_is_shown(): void
    {
        $this->get('/')->assertOk()->assertSee('Žinučių dar nėra.');
    }

    public function test_feed_shows_database_messages_and_authors_newest_first(): void
    {
        $user = User::factory()->create(['name' => 'Testo autorius']);
        $old = $user->chirps()->create(['message' => 'Senesnė žinutė']);
        $old->update(['created_at' => now()->subHour()]);
        $user->chirps()->create(['message' => 'Naujesnė žinutė']);

        $this->get('/')->assertOk()->assertSee('Testo autorius')
            ->assertSeeInOrder(['Naujesnė žinutė', 'Senesnė žinutė']);
    }

    public function test_feed_is_limited_to_fifty_messages(): void
    {
        Chirp::create(['message' => 'Seniausia paslėpta žinutė']);
        for ($i = 1; $i <= 50; $i++) {
            Chirp::create(['message' => 'Žinutė numeris '.$i]);
        }

        $this->get('/')->assertOk()->assertDontSee('Seniausia paslėpta žinutė')
            ->assertSee('Žinutė numeris 50');
    }
}
