<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Job;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

       // User::factory()->create([
         //   'name' => 'Test User',
           // 'email' => 'test@example.com',
        //]);
         // \App\Models\Category::factory(5)->create();
         // \App\Models\JobType::factory(5)->create();
          // \App\Models\User::factory(10)->create();
          Job::factory()->count(25)->create();


    }
}
