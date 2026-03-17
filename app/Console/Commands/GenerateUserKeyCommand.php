<?php

namespace App\Console\Commands;

use App\Models\User;
use Illuminate\Console\Command;

class GenerateUserKeyCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'user:create-key {email} {tokenName}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create User token without tinker access on server';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $email = $this->argument('email');
        $user = User::where('email', $email)->first();
        
        if(!$user) {
            echo "User not found!";
            exit();
        }   
        $serverName = $this->argument('tokenName');
        $token = $user->tokens()->where('name', $serverName)->first();
        if($token) {
            echo "Find old token of ".$serverName."\n";
            $token->delete();
            echo "Deleted old token. Creating new token for ".$serverName;
            echo "\n";
        }
        echo "New token: ";
        echo $user->createToken($serverName)->plainTextToken;
        echo "\n";
        
    }
}
