<?php

namespace Tests\Feature;

use App\Models\Post;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class BlogControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	/**
	 * Teste si la méthode index affiche les articles correctement.
	 *
	 * @return void
	 */
	public function test_index_method_displays_posts()
	{
		$response = $this->get(route('home'));
		
		$response->assertStatus(200);
		$response->assertViewIs('blog.index');
		$response->assertViewHas('posts');
	}
	
	/**
	 * Teste si la méthode show affiche un article spécifique correctement.
	 *
	 * @return void
	 */
	public function test_show_method_displays_post()
	{
		$post = Post::factory()->create();
		
		$response = $this->get(route('show', ['slug' => $post->slug, 'id' => $post->id]));
		
		$response->assertStatus(200);
		$response->assertViewIs('blog.show');
		$response->assertViewHas('post', $post);
		$response->assertViewHas('relatedPosts');
	}
	
	/**
	 * Teste si la méthode show redirige avec le slug correct.
	 *
	 * @return void
	 */
	public function test_show_method_redirects_with_correct_slug()
	{
		$post = Post::factory()->create();
		
		$response = $this->get(route('show', ['slug' => 'incorrect-slug', 'id' => $post->id]));
		
		$response->assertRedirect(route('show', ['slug' => $post->slug, 'id' => $post->id]));
	}
}
