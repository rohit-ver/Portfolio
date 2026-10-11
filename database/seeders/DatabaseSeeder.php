<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Create Admin User
        $adminPassword = env('ADMIN_PASSWORD', 'Admin@123456');
        User::updateOrCreate(
            ['email' => 'rohitv3319@gmail.com'],
            [
                'name' => 'Rohit Verma',
                'password' => Hash::make($adminPassword),
                'email_verified_at' => now(),
            ]
        );

        $this->call([
            SettingSeeder::class,
            ProjectSeeder::class,
            ExperienceSeeder::class,
        ]);
    }
}
