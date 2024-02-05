<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Un Guard model
        Model::unguard();
        
        $this->command->call('migrate:fresh');
        
        $this->command->info('Refreshing database...');
        $this->command->comment('Refreshed!');

        $this->call(UserSedder::class);
        $this->call(BouncerSedder::class);
        $this->command->line('Users & Roles created!');
        
        $this->call(SettingsSeeder::class);
        $this->command->line('Settings created!');
        
        $this->command->comment('Enjoy your app!');
        $this->command->comment('...');
        
        // ReGuard model
        Model::reguard();
    }
}
