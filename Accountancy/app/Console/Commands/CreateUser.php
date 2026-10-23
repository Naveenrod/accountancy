<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Validator;

use function Laravel\Prompts\password;
use function Laravel\Prompts\text;

class CreateUser extends Command
{
    protected $signature = 'app:create-user';

    protected $description = 'Create an account that can log in (there is no sign-up page)';

    public function handle(): int
    {
        $name = text('Name', required: true);
        $email = text('Email', required: true);
        $password = password('Password (at least 8 characters)', required: true);

        $validator = Validator::make(compact('name', 'email', 'password'), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'string', 'min:8'],
        ]);

        if ($validator->fails()) {
            foreach ($validator->errors()->all() as $error) {
                $this->error($error);
            }

            return self::FAILURE;
        }

        User::create(compact('name', 'email', 'password'));
        $this->info("Account created for {$email}. You can now log in.");

        return self::SUCCESS;
    }
}
