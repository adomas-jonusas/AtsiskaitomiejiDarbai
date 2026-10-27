<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\DB;
use Tests\TestCase;

class DatabaseTest extends TestCase
{
    use RefreshDatabase;

    public function test_chirp_can_be_stored_anonymously_during_the_course(): void
    {
        DB::table('chirps')->insert([
            'user_id' => null,
            'message' => 'Pirmoji žinutė duomenų bazėje.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $this->assertDatabaseHas('chirps', ['message' => 'Pirmoji žinutė duomenų bazėje.']);
    }

    public function test_deleting_a_user_also_deletes_their_chirps(): void
    {
        $user = User::factory()->create();
        DB::table('chirps')->insert([
            'user_id' => $user->id,
            'message' => 'Autoriaus žinutė.',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $user->delete();

        $this->assertDatabaseCount('chirps', 0);
    }
}
