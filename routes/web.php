<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use App\Models\User;
use App\Services\Wirechat\EnsureGeneralConversation;
use App\Services\Wirechat\EnsurePrivateConversations;

Route::get('/', function () {
    return redirect()->route('wirechat.chats.chats');
});

Route::middleware('guest')->group(function () {
    Route::get('/register', function () {
        return view('auth.register');
    })->name('register');

    Route::post('/register', function (
        Request $request,
        EnsureGeneralConversation $ensureGeneralConversation,
        EnsurePrivateConversations $ensurePrivateConversations
    ) {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', 'string', 'min:8', 'confirmed'],
        ]);

        $user = User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
        ]);

        Auth::login($user);
        $request->session()->regenerate();
        $ensureGeneralConversation->forUser($user);
        $ensurePrivateConversations->forUser($user);

        return redirect()->intended(route('wirechat.chats.chats'));
    });

    Route::get('/login', function () {
        return view('auth.login');
    })->name('login');

    Route::post('/login', function (
        Request $request,
        EnsureGeneralConversation $ensureGeneralConversation,
        EnsurePrivateConversations $ensurePrivateConversations
    ) {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);

        if (Auth::attempt($credentials, $request->boolean('remember'))) {
            $request->session()->regenerate();
            /** @var User $user */
            $user = Auth::user();
            $ensureGeneralConversation->forUser($user);
            $ensurePrivateConversations->forUser($user);

            return redirect()->intended(route('wirechat.chats.chats'));
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    });
});

Route::post('/logout', function (Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect()->route('login');
})->middleware('auth')->name('logout');
