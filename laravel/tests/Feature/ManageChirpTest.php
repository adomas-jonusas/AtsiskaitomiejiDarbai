<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ManageChirpTest extends TestCase
{
    use RefreshDatabase;

    public function test_a_chirp_can_be_edited(): void
    {
        $user = User::factory()->create();
        $chirp = $user->chirps()->create(['message' => 'Pradinis tekstas']);
        $this->actingAs($user);

        $this->get('/chirps/'.$chirp->id.'/edit')->assertOk()->assertSee('Pradinis tekstas');
        $this->put('/chirps/'.$chirp->id, ['message' => 'Pakeistas tekstas'])
            ->assertRedirect('/')->assertSessionHas('success');
        $this->assertDatabaseHas('chirps', ['id' => $chirp->id, 'message' => 'Pakeistas tekstas']);
    }

    public function test_invalid_updates_keep_the_original_message(): void
    {
        $user = User::factory()->create();
        $chirp = $user->chirps()->create(['message' => 'Pradinis tekstas']);
        $this->actingAs($user);

        foreach (['', str_repeat('a', 256)] as $message) {
            $this->put('/chirps/'.$chirp->id, ['message' => $message])->assertSessionHasErrors('message');
        }

        $this->assertDatabaseHas('chirps', ['id' => $chirp->id, 'message' => 'Pradinis tekstas']);
    }

    public function test_a_chirp_can_be_deleted(): void
    {
        $user = User::factory()->create();
        $chirp = $user->chirps()->create(['message' => 'Ištrinama žinutė']);

        $this->actingAs($user)->delete('/chirps/'.$chirp->id)
            ->assertRedirect('/')->assertSessionHas('success');
        $this->assertDatabaseMissing('chirps', ['id' => $chirp->id]);
    }

    public function test_an_edited_chirp_has_an_indicator(): void
    {
        $user = User::factory()->create();
        $chirp = $user->chirps()->create(['message' => 'Ankstesnė žinutė']);
        $this->travel(10)->seconds();
        $this->actingAs($user)->put('/chirps/'.$chirp->id, ['message' => 'Redaguota žinutė'])->assertRedirect('/');

        $this->get('/')->assertSee('redaguota');
        $this->travelBack();
    }
}
