<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChirpModelTest extends TestCase
{
    use RefreshDatabase;

    public function test_user_and_chirp_relationships_work_in_both_directions(): void
    {
        $user = User::factory()->create();
        $chirp = $user->chirps()->create(['message' => 'Eloquent žinutė.']);

        $this->assertTrue($chirp->user->is($user));
        $this->assertTrue($user->chirps->first()->is($chirp));
        $this->assertDatabaseHas('chirps', ['user_id' => $user->id, 'message' => 'Eloquent žinutė.']);
    }
}
