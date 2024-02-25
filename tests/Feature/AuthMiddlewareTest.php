<?php

namespace Tests\Feature;

use App\Models\Post;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Auth;
use Tests\TestCase;

class AuthMiddlewareTest extends TestCase
{
	use RefreshDatabase;
	use RefreshDatabase, WithFaker;
	
	/**
	 * Test de l'authentification pour l'accès aux actions liées au modèle Post.
	 *
	 * @return void
	 */
	public function test_user_must_be_authenticated_for_post_actions()
	{
		// Créer un utilisateur
		$user = User::factory()->create([
			'email' => $this->faker->unique()->safeEmail(),
		]);
		
		Post::factory()->create(['user_id' => $user->id]);
		
		// Utilisateur non connecté
		$response = $this->get(route('admin.post.index'));
		$response->assertRedirect(route('login'));
		
		$response->assertStatus(302);
		
		// Utilisateur connecté
		$user = User::factory()->create();
		$this->actingAs($user);
		
		$response = $this->get(route('admin.post.index'));
		$response->assertOk();
	}
	
	/**
	 * Test de l'authentification pour l'accès aux actions liées au modèle Category.
	 *
	 * @return void
	 */
	public function test_user_must_be_authenticated_for_category_actions()
	{
		// Utilisateur non connecté
		$response = $this->get(route('admin.category.index'));
		$response->assertRedirect(route('login'));
		
		$response->assertStatus(302);
		
		// Utilisateur connecté
		$user = User::factory()->create();
		$this->actingAs($user);
		
		$response = $this->get(route('admin.category.index'));
		$response->assertOk();
	}
	
	/**
	 * Teste si l'utilisateur connecté est redirigé lorsqu'il essaie d'accéder à la page de connexion.
	 *
	 * @return void
	 */
	public function test_logged_in_user_is_redirected_from_home_page()
	{
		// Créer un utilisateur et le connecter
		$user = User::factory()->create();
		$this->actingAs($user);
		
		// Accéder à la page de connexion
		$response = $this->get(route('login'));
		
		// Vérifier que l'utilisateur est redirigé
		$response->assertRedirect(route('home'));
	}
	
	/**
	 * Teste si l'utilisateur est correctement déconnecté.
	 *
	 * @return void
	 */
	public function test_user_can_logout()
	{
		$user = User::factory()->create();
		Auth::login($user);
		
		$response = $this->delete(route('logout'));
		
		// Vérification que l'utilisateur est redirigé après la déconnexion
		$response->assertRedirect(route('home'));
		
		// Vérification que l'utilisateur est bien déconnecté
		$this->assertGuest();
	}
}
