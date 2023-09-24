<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    // start data
     public function definition(): array
    {
        return [
            // "user_name" => $this->faker->name(), //name
            "title" => $this->faker->sentence(),
            "body" => $this->faker->paragraph(),
            "category_id" => rand(1,5),
            "user_id" => rand(1,2),

        ]; //$data
    }
}
