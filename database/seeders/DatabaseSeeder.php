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
        $grades = [
            'Pre-School',
            'Play Group',
            'Kindergarten',
            'Lower Primary',
            'Upper Primary',
            'Junior Secondary',
            'High School',
            'College',
            'University',
            'Adult Learning',
            'Other',
        ];

        foreach ($grades as $grade) {
            \App\Models\Grade::firstOrCreate(['name' => $grade]);
        }

        $categories = [
            'Story Books',
            'Textbooks',
            'Reference Books',
            'Picture Books',
            'Early Readers',
            'Children Fiction',
            'Young Adult',
            'Science & Nature',
            'History & Culture',
            'Mathematics',
            'Languages',
            'Comics',
            'Poems',
            'Plays',
            'Revision Material',
            'Life Skills',
            'Religion & Values',
            'Other',
        ];

        foreach ($categories as $category) {
            \App\Models\Category::firstOrCreate(['name' => $category]);
        }

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
