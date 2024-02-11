<?php

namespace Database\Factories;

use App\Models\Category;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        if (Category::count() === 0) {
            Category::factory(5)->create();
        }

        $title = fake()->name();
        $slug = Str::slug($title);

        return [
            "title" => $title,
            "slug" => $slug,
            "content" => fake()->sentence(10),
            "category_id" => Category::inRandomOrder()->first()->id,
            "published" => Arr::random([true, false])
        ];
    }
}
