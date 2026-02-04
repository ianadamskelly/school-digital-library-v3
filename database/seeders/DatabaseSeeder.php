<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // 1. Seed Grades
        $grades = [
            'Play Group',
            'Kindergarten',
            'Grade 1',
            'Grade 2',
            'Grade 3',
            'Grade 4',
            'Grade 5',
            'Grade 6',
            'Grade 7',
            'Grade 8',
            'Grade 9',
            'Grade 10',
            'Grade 11',
            'Grade 12'
        ];

        foreach ($grades as $grade) {
            \App\Models\Grade::firstOrCreate(['name' => $grade]);
        }

        // 2. Seed Categories
        $categories = [
            'Story Books',
            'Textbooks',
            'Reference Books',
            'Comics',
            'Poems',
            'Plays',
            'Revision Material'
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(['name' => $category]);
        }

        // 3. Test User
        User::updateOrCreate(
            ['email' => 'john@example.com'],
            [
                'name' => 'John Doe',
                'role' => 'teacher',
                'password' => bcrypt('password'),
            ]
        );
    }
}
