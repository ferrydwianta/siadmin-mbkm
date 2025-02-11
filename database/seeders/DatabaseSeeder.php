<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        User::factory()->create([
            'name' => 'User Admin',
            'email' => 'admin@example.com',
        ])->assignRole(Role::create([
            'name' => 'Admin',
        ]));

        $lecturer = User::factory()->create([
            'name' => 'User Lecturer',
            'email' => 'lecturer@example.com',
        ])->assignRole(Role::create([
            'name' => 'Lecturer'
        ]));

        $lecturer->lecturer()->create([
            'lecturer_number' => str()->padLeft(mt_rand(0, 999999), 6, '0'),
            'full_name' => 'user lecturer',
            'academic_title' => 'lecturer'
        ]);

        $student = User::factory()->create([
            'name' => 'User Student',
            'email' => 'student@example.com',
        ])->assignRole(Role::create([
            'name' => 'Student'
        ]));

        $student->student()->create([
            // 'activity_id' => 1,
            'student_number' => str()->padLeft(mt_rand(0, 999999), 6, '0'),
            'semester' => 1,
            'batch' => 2021,
            'full_name' => 'user student',
        ]);

    }
}
