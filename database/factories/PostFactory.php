<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\User;
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
		
		$title = $this->faker->name();
		$slug = Str::slug($title);
		// $imagePath = 'images/' . date('Y') . '/' . date('m') . '/' . $this->faker->image(storage_path('app/public'),400, 300, null, false);
		
		
		$admin = User::first() ?? User::factory()->create();
		
		
		return [
			"title" => $title,
			"slug" => $slug,
			"content" => $this->faker->paragraphs(30, true),
			"category_id" => Category::inRandomOrder()->first()->id,
			"image" => null,
			"published" => Arr::random([true, false]),
			"user_id" => $admin->id
		];
	}
}
