<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use JsonException;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
	use RefreshDatabase;
	use WithFaker;
	
	/**
	 * Test de la méthode index pour afficher la liste des catégories.
	 *
	 * @return void
	 */
	public function test_index_method_displays_list_of_categories()
	{
		$this->signInUser();
		
		// Créer des catégories de test
		Category::factory()->count(10)->create();
		
		$response = $this->get(route('admin.category.index'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.category.index');
		$response->assertViewHas('categories');
	}
	
	/**
	 * Permet de créer un utilisateur
	 * @return void
	 */
	protected function signInUser()
	{
		// Créer et connecter un utilisateur fictif
		$user = User::factory()->create();
		$this->actingAs($user);
	}
	
	/**
	 * Test de la méthode create pour afficher le formulaire de création de catégorie.
	 *
	 * @return void
	 */
	public function test_create_method_displays_category_create_form()
	{
		$this->signInUser();
		
		$response = $this->get(route('admin.category.create'));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.category.create');
		$response->assertViewHas('category');
	}
	
	
	/**
	 * @throws JsonException
	 */
	public function test_store_method_creates_new_category_bad_request()
	{
		$this->signInUser();
		
		$categoryData = [
			'name' => "Ma catégorie",
		];
		
		$response = $this->post(route('admin.category.store'), $categoryData);
		
		// $response->assertRedirect(route('admin.category.index'));
		$response->assertSessionHasNoErrors();
		
		$this->assertDatabaseHas('categories', $categoryData);
	}
	
	/**
	 * Test de la méthode store pour créer une nouvelle catégorie.
	 *
	 * @return void
	 */
	public function test_store_method_creates_new_category()
	{
		$this->signInUser();
		
		$categoryData = [
			'name' => "Ma catégorie",
		];
		
		$response = $this->post(route('admin.category.store'), $categoryData);
		
		// Ajoutez les paramètres de requête attendus à l'URL de redirection
		$expectedUrl = route('admin.category.index', [
			'page' => 1,
			'field' => 'created_at',
			'orderDirection' => 'desc'
		]);
		
		// Vérifiez que l'URL de redirection correspond à l'URL attendue
		$response->assertRedirect($expectedUrl);
		
		$this->assertDatabaseHas('categories', $categoryData);
	}
	
	/**
	 * Test de la méthode edit pour afficher le formulaire d'édition de catégorie.
	 *
	 * @return void
	 */
	public function test_edit_method_displays_category_edit_form()
	{
		$this->signInUser();
		
		$category = Category::factory()->create();
		
		$response = $this->get(route('admin.category.edit', $category));
		
		$response->assertStatus(200);
		$response->assertViewIs('admin.category.edit');
		$response->assertViewHas('category', $category);
	}
	
	/**
	 * Test de la méthode update pour mettre à jour une catégorie.
	 *
	 * @return void
	 */
	public function test_update_method_updates_category()
	{
		$this->signInUser();
		
		$category = Category::factory()->create();
		$updatedData = ['name' => 'Updated Category Name'];
		
		$response = $this->put(route('admin.category.update', $category), $updatedData);
		
		$response->assertRedirect(route('admin.category.index'));
		$this->assertDatabaseHas('categories', array_merge(['id' => $category->id], $updatedData));
	}
	
	/**
	 * Test de la méthode destroy pour supprimer une catégorie.
	 *
	 * @return void
	 */
	public function test_destroy_method_deletes_category()
	{
		$this->signInUser();
		
		$category = Category::factory()->create();
		
		$response = $this->delete(route('admin.category.destroy', $category));
		
		$response->assertRedirect(route('admin.category.index'));
		$this->assertDatabaseMissing('categories', ['id' => $category->id]);
	}
	
	/**
	 * Teste si la suppression d'une catégorie met à jour le category_id de tous les articles associés.
	 *
	 * @return void
	 */
	public function test_deleting_category_updates_category_id_of_related_posts_to_null()
	{
		$this->signInUser();
		
		// Création d'une catégorie et de plusieurs articles associés
		$category = Category::factory()->create();
		$posts = Post::factory(3)->create(['category_id' => $category->id]);
		
		// Suppression de la catégorie
		$this->delete(route('admin.category.destroy', $category));
		
		// Vérification que le category_id de tous les articles associés est mis à null
		foreach ($posts as $post) {
			$this->assertDatabaseHas('posts', [
				'id' => $post->id,
				'category_id' => null,
			]);
		}
	}
}
