<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class ChirpSeeder extends Seeder
{
    public function run(): void
    {
        $examples = [
            ['Jonas', 'jonas@example.test', 'Mokausi kurti žinutes su Laravel.'],
            ['Ieva', 'ieva@example.test', 'Blade komponentai leidžia pakartotinai naudoti puslapio dalis.'],
            ['Tomas', 'tomas@example.test', 'Pirmasis Chirper projektas jau veikia!'],
        ];

        foreach ($examples as [$name, $email, $message]) {
            $user = User::firstOrCreate(['email' => $email], [
                'name' => $name,
                'password' => Str::random(40),
            ]);
            $user->chirps()->firstOrCreate(['message' => $message]);
        }
    }
}
