<?php

namespace App\Http\Controllers;

use App\Models\Chirp;
use Illuminate\View\View;

class ChirpController extends Controller
{
    public function index(): View
    {
        $chirps = Chirp::with('user')->latest()->latest('id')->take(50)->get();

        return view('home', ['chirps' => $chirps]);
    }
}
