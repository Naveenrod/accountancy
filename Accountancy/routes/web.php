<?php

use App\Livewire\ClientForm;
use App\Livewire\Clientlist;
use App\Livewire\Homepage;
use App\Livewire\Login;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/login', Login::class)->middleware('guest')->name('login');

Route::middleware('auth')->group(function () {
    Route::get('/', Homepage::class)->name('home');
    Route::get('/clients', Clientlist::class)->name('clientlist');
    Route::get('/clients/create', ClientForm::class)->name('clients.create');
    Route::get('/clients/{clientId}/edit', ClientForm::class)->name('clients.edit');

    Route::post('/logout', function () {
        Auth::logout();
        session()->invalidate();
        session()->regenerateToken();

        return redirect()->route('login');
    })->name('logout');
});
