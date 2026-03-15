<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Artisan;
use Tests\TestCase;

class DatabaseSeederTest extends TestCase
{
    use RefreshDatabase;

    public function test_database_seeder_populates_expected_categories_and_grades(): void
    {
        Artisan::call('db:seed', ['--class' => 'Database\\Seeders\\DatabaseSeeder', '--no-interaction' => true]);

        $this->assertDatabaseHas('grades', ['name' => 'Pre-School']);
        $this->assertDatabaseHas('grades', ['name' => 'Lower Primary']);
        $this->assertDatabaseHas('grades', ['name' => 'Upper Primary']);
        $this->assertDatabaseHas('grades', ['name' => 'High School']);
        $this->assertDatabaseHas('grades', ['name' => 'College']);
        $this->assertDatabaseHas('grades', ['name' => 'Other']);

        $this->assertDatabaseHas('categories', ['name' => 'Picture Books']);
        $this->assertDatabaseHas('categories', ['name' => 'Science & Nature']);
        $this->assertDatabaseHas('categories', ['name' => 'Life Skills']);
        $this->assertDatabaseHas('categories', ['name' => 'Other']);
    }
}
