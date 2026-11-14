<?php

namespace Tests\Feature;

use App\Livewire\Login;
use App\Models\Client;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Livewire\Livewire;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_guests_are_sent_to_the_login_page(): void
    {
        foreach (['/', '/clients', '/clients/create'] as $url) {
            $this->get($url)->assertRedirect('/login');
        }

        $this->post('/logout')->assertRedirect('/login');
    }

    public function test_login_page_loads_without_the_app_navigation(): void
    {
        $this->get('/login')->assertOk()->assertSee('Log in')->assertDontSee('Log out');
    }

    public function test_a_user_can_log_in_and_is_sent_where_they_were_going(): void
    {
        $user = User::factory()->create(['email' => 'me@example.com', 'password' => 'secret-password']);

        $this->get('/clients');

        Livewire::test(Login::class)
            ->set('email', 'me@example.com')
            ->set('password', 'secret-password')
            ->call('login')
            ->assertRedirect('/clients');

        $this->assertAuthenticatedAs($user);
    }

    public function test_a_wrong_password_is_rejected(): void
    {
        User::factory()->create(['email' => 'me@example.com']);

        Livewire::test(Login::class)
            ->set('email', 'me@example.com')
            ->set('password', 'wrong-password')
            ->call('login')
            ->assertHasErrors('email')
            ->assertSet('password', '');

        $this->assertGuest();
    }

    public function test_login_is_locked_after_five_failed_attempts(): void
    {
        User::factory()->create(['email' => 'me@example.com', 'password' => 'secret-password']);

        $login = Livewire::test(Login::class)->set('email', 'me@example.com');

        foreach (range(1, 5) as $attempt) {
            $login->set('password', 'wrong-password')->call('login');
        }

        $login->set('password', 'secret-password')
            ->call('login')
            ->assertSee('Too many login attempts');

        $this->assertGuest();
    }

    public function test_logged_in_users_are_sent_away_from_the_login_page(): void
    {
        $this->actingAs(User::factory()->create())->get('/login')->assertRedirect('/');
    }

    public function test_a_user_can_log_out(): void
    {
        $this->actingAs(User::factory()->create())
            ->post('/logout')
            ->assertRedirect('/login');

        $this->assertGuest();
    }

    public function test_client_actions_are_blocked_once_logged_out(): void
    {
        $client = Client::factory()->create();
        $html = $this->actingAs(User::factory()->create())->get('/clients')->getContent();
        preg_match_all('/wire:snapshot="([^"]+)"/', $html, $matches);
        $snapshot = collect($matches[1])
            ->map(fn ($snapshot) => html_entity_decode($snapshot))
            ->first(fn ($snapshot) => str_contains($snapshot, '"name":"clientlist"'));
        $this->assertNotNull($snapshot);

        Auth::logout();

        $this->postJson('/livewire/update', ['components' => [[
            'snapshot' => $snapshot,
            'updates' => [],
            'calls' => [['path' => '', 'method' => 'pushContact', 'params' => [$client->id, 'xero']]],
        ]]], ['X-Livewire' => 'true'])->assertUnauthorized();

        $this->assertDatabaseCount('client_syncs', 0);
    }

    public function test_there_is_no_sign_up_page(): void
    {
        $this->get('/register')->assertNotFound();
    }
}
