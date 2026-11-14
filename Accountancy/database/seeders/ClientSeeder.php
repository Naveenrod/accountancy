<?php

namespace Database\Seeders;

use App\Models\Client;
use Illuminate\Database\Seeder;

class ClientSeeder extends Seeder
{
    /**
     * Sample clients with their Xero, QuickBooks and Sage sync statuses.
     */
    public function run(): void
    {
        $clients = [
            ['Acme Corp', 'contact@acmecorp.com', 'Not Started', 'Not Started', 'Not Started'],
            ['Wayne Enterprises', 'info@wayne.com', 'In Progress', 'Completed', 'Not Started'],
            ['Stark Industries', 'support@starkindustries.com', 'Completed', 'In Progress', 'Completed'],
            ['Umbrella Corp', 'admin@umbrella.com', 'In Progress', 'Not Started', 'Not Started'],
            ['Oscorp', 'contact@oscorp.com', 'Completed', 'Not Started', 'In Progress'],
            ['LexCorp', 'info@lexcorp.com', 'Not Started', 'Completed', 'In Progress'],
            ['Cyberdyne Systems', 'contact@cyberdyne.com', 'In Progress', 'In Progress', 'Not Started'],
            ['Blue Sky Studios', 'support@bluesky.com', 'Completed', 'Not Started', 'In Progress'],
            ['InGen', 'admin@ingen.com', 'In Progress', 'Completed', 'Not Started'],
            ['Weyland-Yutani Corp', 'info@weyland.com', 'Not Started', 'In Progress', 'Completed'],
            ['Tyrell Corporation', 'contact@tyrellcorp.com', 'Completed', 'Completed', 'Not Started'],
            ['Cybertronix', 'support@cybertronix.com', 'Not Started', 'In Progress', 'Completed'],
            ['Pied Piper', 'info@piedpiper.com', 'In Progress', 'Completed', 'Completed'],
            ['Vandelay Industries', 'contact@vandelay.com', 'Completed', 'Not Started', 'In Progress'],
            ['Hooli', 'admin@hooli.com', 'Not Started', 'Completed', 'In Progress'],
        ];

        foreach ($clients as [$name, $email, $xero, $quickbooks, $sage]) {
            $client = Client::create(['name' => $name, 'email' => $email]);

            foreach (['xero' => $xero, 'quickbooks' => $quickbooks, 'sage' => $sage] as $service => $status) {
                $client->syncs()->create(['service' => $service, 'status' => $status]);
            }
        }
    }
}
