<?php

namespace Tests\Feature;

use App\Models\Chirp;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthorizationTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_cannot_create_edit_update_or_delete_chirps(): void
    {
        $owner = User::factory()->create();
        $chirp = $owner->chirps()->create(['message' => 'Saugoma žinutė']);

        $this->post('/chirps', ['message' => 'Nauja'])->assertRedirect('/login');
        $this->get('/chirps/'.$chirp->id.'/edit')->assertRedirect('/login');
        $this->put('/chirps/'.$chirp->id, ['message' => 'Pakeista'])->assertRedirect('/login');
        $this->delete('/chirps/'.$chirp->id)->assertRedirect('/login');
        $this->assertDatabaseCount('chirps', 1);
        $this->assertDatabaseHas('chirps', ['id' => $chirp->id, 'message' => 'Saugoma žinutė']);
    }

    public function test_another_user_cannot_edit_update_or_delete_someone_elses_chirp(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $chirp = $owner->chirps()->create(['message' => 'Svetima žinutė']);
        $this->actingAs($other);

        $this->get('/chirps/'.$chirp->id.'/edit')->assertForbidden();
        $this->put('/chirps/'.$chirp->id, ['message' => 'Pakeista'])->assertForbidden();
        $this->delete('/chirps/'.$chirp->id)->assertForbidden();
        $this->get('/')->assertDontSee('Redaguoti')->assertDontSee('Ištrinti');
        $this->assertDatabaseHas('chirps', ['id' => $chirp->id, 'message' => 'Svetima žinutė']);
    }

    public function test_a_forged_user_id_cannot_change_the_author(): void
    {
        $owner = User::factory()->create();
        $other = User::factory()->create();
        $this->actingAs($owner)->post('/chirps', ['message' => 'Mano žinutė', 'user_id' => $other->id])
            ->assertRedirect('/');

        $chirp = Chirp::firstOrFail();
        $this->assertSame($owner->id, $chirp->user_id);
        $this->put('/chirps/'.$chirp->id, ['message' => 'Naujas tekstas', 'user_id' => $other->id])
            ->assertRedirect('/');
        $this->assertSame($owner->id, $chirp->fresh()->user_id);
    }

    public function test_legacy_anonymous_chirps_cannot_be_taken_over(): void
    {
        $chirp = Chirp::create(['message' => 'Sena anoniminė žinutė']);
        $this->actingAs(User::factory()->create());

        $this->put('/chirps/'.$chirp->id, ['message' => 'Pakeista'])->assertForbidden();
        $this->delete('/chirps/'.$chirp->id)->assertForbidden();
    }
}
