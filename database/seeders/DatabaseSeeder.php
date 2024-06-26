<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
  /**
   * Seed the application's database.
   */
  public function run(): void
  {
    \App\Models\User::factory()->admin()->create();
    \App\Models\User::factory()->client()->create();

    $this->call([
      BookSeeder::class,
    ]);
  }
}
