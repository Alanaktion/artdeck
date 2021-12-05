<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Hash;

class AddUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:add';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add a user';

    /**
     * Execute the console command.
     */
    public function handle(): int
    {
        $name = $this->ask("Display name");
        $email = $this->ask("Email address");
        $password = $this->secret("New password");
        $user = User::forceCreate([
            'name' => $name,
            'email' => $email,
            'password' => Hash::make($password),
        ]);
        $this->info('Created user with ID ' . $user->id);
        return 0;
    }
}
