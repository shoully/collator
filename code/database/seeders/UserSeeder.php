<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Create/Update Mentor users
        User::updateOrCreate(
            ['email' => 'mentor@sharehub.com'],
            [
                'name' => 'John Mentor',
                'password' => Hash::make('password'),
                'phone' => '+1234567890',
                'bio' => 'Experienced mentor with 10+ years in software development',
                'type' => 'Mentor',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'sarah.mentor@sharehub.com'],
            [
                'name' => 'Sarah Mentor',
                'password' => Hash::make('password'),
                'phone' => '+1234567891',
                'bio' => 'Business mentor specializing in entrepreneurship',
                'type' => 'Mentor',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'michael.mentor@sharehub.com'],
            [
                'name' => 'Michael Mentor',
                'password' => Hash::make('password'),
                'phone' => '+1234567892',
                'bio' => 'Career coach and professional development expert',
                'type' => 'Mentor',
                'email_verified_at' => now(),
            ]
        );

        // Create/Update Mentee users
        User::updateOrCreate(
            ['email' => 'mentee@sharehub.com'],
            [
                'name' => 'Alice Mentee',
                'password' => Hash::make('password'),
                'phone' => '+1234567893',
                'bio' => 'Aspiring developer looking for guidance',
                'type' => 'Mentee',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'bob.mentee@sharehub.com'],
            [
                'name' => 'Bob Mentee',
                'password' => Hash::make('password'),
                'phone' => '+1234567894',
                'bio' => 'Student seeking career mentorship',
                'type' => 'Mentee',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'emma.mentee@sharehub.com'],
            [
                'name' => 'Emma Mentee',
                'password' => Hash::make('password'),
                'phone' => '+1234567895',
                'bio' => 'New professional looking for mentorship',
                'type' => 'Mentee',
                'email_verified_at' => now(),
            ]
        );

        // Create/Update Guest users
        User::updateOrCreate(
            ['email' => 'guest@sharehub.com'],
            [
                'name' => 'Guest User',
                'password' => Hash::make('password'),
                'phone' => '',
                'bio' => 'Guest user with limited access',
                'type' => 'guest',
                'email_verified_at' => now(),
            ]
        );

        User::updateOrCreate(
            ['email' => 'visitor@sharehub.com'],
            [
                'name' => 'Visitor Guest',
                'password' => Hash::make('password'),
                'phone' => '',
                'bio' => '',
                'type' => 'guest',
                'email_verified_at' => now(),
            ]
        );

        $this->command->info('✅ Created 3 Mentor users');
        $this->command->info('✅ Created 3 Mentee users');
        $this->command->info('✅ Created 2 Guest users');
        $this->command->info('📧 All users have password: password');
    }
}
