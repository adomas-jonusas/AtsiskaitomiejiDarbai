<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class Login extends Controller
{
    public function __invoke(Request $request): RedirectResponse
    {
        $credentials = $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => ['required', 'string'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();

            return redirect()->intended('/')->with('success', 'Sėkmingai prisijungei!');
        }

        return back()->withErrors(['email' => 'Neteisingas el. paštas arba slaptažodis.'])
            ->onlyInput('email');
    }
}
