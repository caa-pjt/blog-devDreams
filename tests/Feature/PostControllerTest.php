<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class PostControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	/**
	 * Teste si la méthode index affiche la liste des articles.
	 *
	 * @return void
	 */
	public function test_index_method_displays_list_of_posts()
	{
		$this->signInUser();
		
		$response = $this->get(route('admin.post.index'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.post.index');
		$response->assertViewHas('posts');
	}
	
	/**
	 * Permet de créer un utilisateur et de le connecter.
	 *
	 * @return void
	 */
	protected function signInUser()
	{
		// Créer et connecter un utilisateur fictif
		$user = User::factory()->create();
		$this->actingAs($user);
	}
	
	/**
	 * Teste si la méthode create affiche le formulaire de création d'article.
	 *
	 * @return void
	 */
	public function test_create_method_displays_post_creation_form()
	{
		$this->signInUser();
		
		$response = $this->get(route('admin.post.create'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.post.create');
		$response->assertViewHas('post');
		$response->assertViewHas('categories', Category::all());
	}
	
	/**
	 * Teste si la méthode store crée un nouvel article.
	 *
	 * @return void
	 */
	public function test_store_method_creates_new_post()
	{
		$this->signInUser();
		
		$image = UploadedFile::fake()->image('post.jpg');
		
		$postData = Post::factory()->raw([
			'image' => $image,
		]);
		
		$response = $this->post(route('admin.post.store'), $postData);
		
		$response->assertRedirect(route('admin.post.index'));
		$this->assertDatabaseHas('posts', [
			'title' => $postData['title']
		]);
		
		// Ici il faut supprimer les images uploadées pour ne pas encombrer le disque
		Storage::disk('public')->deleteDirectory('images');
	}
	
	
	/**
	 * Teste si la méthode edit affiche le formulaire d'édition d'article.
	 *
	 * @return void
	 */
	public function test_edit_method_displays_post_edit_form()
	{
		$this->signInUser();
		
		$post = Post::factory()->create();
		
		$response = $this->get(route('admin.post.edit', $post));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.post.edit');
		$response->assertViewHas('post', $post);
		
		$response->assertViewHas('categories');
	}
	
	/**
	 * Teste si la méthode edit affiche le formulaire d'édition du post avec les informations correctes.
	 *
	 * @return void
	 */
	public function test_edit_method_displays_post_data()
	{
		$this->signInUser();
		
		$category = Category::factory()->create();
		
		$post = Post::factory()->create([
			'title' => 'Test Title',
			'content' => 'Test Content',
			'category_id' => $category->id
		]);
		
		$response = $this->get(route('admin.post.edit', $post));
		$response->assertStatus(200);
		
		$response->assertViewHas('post', function ($viewPost) use ($post) {
			return $viewPost->id === $post->id
				&& $viewPost->title === $post->title
				&& $viewPost->content === $post->content
				&& $viewPost->category_id === $post->category_id;
		});
		
		$response->assertViewHas('categories');
	}
	
	/**
	 * Teste si la méthode update met à jour les données du post.
	 *
	 * @return void
	 */
	public function test_update_method_updates_post_data()
	{
		
		$this->signInUser();
		$category = Category::factory()->create();
		
		$post = Post::factory()->create([
			'title' => 'Titre original',
			'content' => 'Contenu original de mon article',
			'category_id' => $category->id
		]);
		
		// Données mises à jour du post
		$updatedData = [
			'title' => 'Titre modifié',
			'content' => 'Le contenu de mon article est modifié',
			'category_id' => Category::factory()->create()->id
		];
		
		// Requête PUT pour mettre à jour le post
		$response = $this->put(route('admin.post.update', $post), $updatedData);
		
		// Assure que la redirection vers la liste des posts a eu lieu
		$response->assertRedirect(route('admin.post.index'));
		
		// Vérifie que les données ont été correctement mises à jour
		$this->assertDatabaseHas('posts', array_merge(['id' => $post->id], $updatedData));
	}
	
	/**
	 * Teste si la méthode store crée un nouvel article assigné à l'utilisateur connecté.
	 *
	 * @return void
	 */
	public function test_store_method_creates_new_post_assigned_to_authenticated_user()
	{
		
		$this->signInUser();
		
		$image = UploadedFile::fake()->image('post.jpg');
		
		$postData = Post::factory()->raw([
			'image' => $image,
		]);
		
		$response = $this->post(route('admin.post.store'), $postData);
		
		$response->assertRedirect(route('admin.post.index'));
		
		$userId = auth()->id();
		
		$this->assertDatabaseHas('posts', [
			'title' => $postData['title'],
			'user_id' => $userId,
		]);
		
		// Ici il faut supprimer les images uploadées pour ne pas encombrer le disque
		Storage::disk('public')->deleteDirectory('images');
		
	}
	
	
	/**
	 * Teste si la méthode destroy supprime un article.
	 *
	 * @return void
	 */
	public function test_destroy_method_deletes_post()
	{
		$this->signInUser();
		
		$post = Post::factory()->create();
		
		$response = $this->delete(route('admin.post.destroy', $post));
		
		$response->assertRedirect(route('admin.post.index'));
		$this->assertDatabaseMissing('posts', ['id' => $post->id]);
	}
	
}
