<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class CreateUserCommandTest extends TestCase
{
    use RefreshDatabase;

    public function test_it_creates_a_user_with_a_hashed_password(): void
    {
        $this->artisan('app:create-user')
            ->expectsQuestion('Name', 'Naveen')
            ->expectsQuestion('Email', 'me@example.com')
            ->expectsQuestion('Password (at least 8 characters)', 'secret-password')
            ->expectsOutputToContain('Account created for me@example.com')
            ->assertSuccessful();

        $user = User::firstWhere('email', 'me@example.com');
        $this->assertTrue(Hash::check('secret-password', $user->password));
    }

    public function test_it_rejects_a_short_password_and_a_taken_email(): void
    {
        User::factory()->create(['email' => 'me@example.com']);

        $this->artisan('app:create-user')
            ->expectsQuestion('Name', 'Naveen')
            ->expectsQuestion('Email', 'me@example.com')
            ->expectsQuestion('Password (at least 8 characters)', 'short')
            ->expectsOutputToContain('The email has already been taken.')
            ->expectsOutputToContain('The password field must be at least 8 characters.')
            ->assertFailed();

        $this->assertSame(1, User::count());
    }
}
