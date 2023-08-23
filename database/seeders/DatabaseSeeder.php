<?php

namespace Database\Seeders;

use App\Models\ClaimStatus;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {

        $this->call([
            RoleSeeder::class,
        ]);

        $this->call([
            UserSeeder::class,
        ]);
        $this->call([
            ClaimStatusSeeder::class,
        ]);
        $this->command->info('All table is seeded!');
        // \App\Models\User::factory(10)->create();
    }
}
