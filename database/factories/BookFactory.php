<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\{Arr, Str};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Book>
 */
class BookFactory extends Factory
{
  /**
   * Define the model's default state.
   *
   * @return array<string, mixed>
   */
  public function definition(): array
  {
    return [
      'title' => fake()->title(),
      'author' => fake()->name(),
      'genre' => Arr::random(['Horror', 'Comedy', 'Adventure', 'True Story']),
      'book_number' => Str::random(5),
      'is_available' => Arr::random([true, false]),
    ];
  }
}
