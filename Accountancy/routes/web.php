<?php

use App\Livewire\ClientForm;
use App\Livewire\Clientlist;
use App\Livewire\Homepage;
use Illuminate\Support\Facades\Route;

Route::get('/', Homepage::class)->name('home');
Route::get('/clients', Clientlist::class)->name('clientlist');
Route::get('/clients/create', ClientForm::class)->name('clients.create');
Route::get('/clients/{clientId}/edit', ClientForm::class)->name('clients.edit');
