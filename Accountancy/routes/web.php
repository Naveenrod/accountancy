<?php

use App\Livewire\Clientlist;
use App\Livewire\Homepage;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name('home');
Route::get('/clients', Clientlist::class)->name('clientlist');
