<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class ChirpController extends Controller
{
    public function index(): View
    {
        $chirps = [
            ['author' => 'Jonas', 'message' => 'Mokausi Laravel!', 'time' => 'Prieš 5 minutes'],
            ['author' => 'Ieva', 'message' => 'Pirmasis Chirper puslapis jau veikia.', 'time' => 'Prieš valandą'],
        ];

        return view('home', ['chirps' => $chirps]);
    }
}
