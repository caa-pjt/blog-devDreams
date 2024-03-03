<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

/**
 * Composant Livewire pour la gestion du tableau des articles.
 */
class PostsTable extends Component
{
	use WithPagination;
	
	#[Url(except: '')]
	public string $search = '';
	#[Url]
	public string $postField = 'title';
	#[Url]
	public string $orderDirection = 'asc';
	
	public $post = '';
	public $page;
	public $method;
	public int $perpPage = 10;
	protected $paginationTheme = 'bootstrap';
	
	/**
	 * Montage du composant avec les paramètres donnés.
	 *
	 * @param string $postField Champ pour le tri
	 * @param string $orderDirection Direction de tri
	 * @param int $page Numéro de page actuel
	 * @param string $method Méthode pour la pagination
	 * @return void
	 */
	public function mount($postField, $orderDirection, $page, $method): void
	{
		$this->postField = $postField;
		$this->orderDirection = $orderDirection;
		$this->page = $page;
		$this->method = $method;
		
		if ($this->method !== false) {
			$this->updatedPage($this->page);
		}
	}
	
	
	public function updatedPage($p = null): void
	{
		if ($p !== null) {
			Session::put('page', $p);
		} else {
			Session::put('page', $this->getPage());
		}
	}
	
	/**
	 * Définir les données de l'article.
	 *
	 * @param Post $post Données de l'article
	 * @return void
	 */
	public function postData(Post $post): void
	{
		$this->post = $post;
		
		$this->openModal();
		
	}
	
	public function openModal(): void
	{
		$this->dispatch('showModal', model: 'post');
		
	}
	
	
	#[On('post-delete')]
	public function deletePost(): void
	{
		
		if ($this->post->exists()) {
			
			// Supprimer le post
			$this->post->delete();
			
			// Mettre à jour la pagination après la suppression
			$this->updatePagination();
			
			// Emission des messages flash
			$this->setFlashMessages('success', 'Catégorie supprimée avec succès.');
			
			// Réinitialiser la propriété après la suppression
			$this->reset(['post']);
			
		} else {
			
			// Emission des messages flash
			$this->setFlashMessages('error', 'La Catégorie que vous essayez de supprimer n\'existe pas.');
		}
	}
	
	/**
	 * Mettre à jour la pagination.
	 *
	 * @param bool $return Retourner la valeur de la page
	 * @return void|int
	 */
	public function updatePagination(bool $return = false)
	{
		$count = Post::count();
		$this->page = $this->getPage();
		$nbrPages = (int)ceil($count / $this->perpPage);
		
		if ($this->page > $nbrPages) {
			if ($return) {
				return $nbrPages;
			} else {
				$this->setPage($nbrPages);
			}
		}
	}
	
	/**
	 * Émission des messages flash. (composant livewire)
	 *
	 * @param string $type Type de message
	 * @param string $message Contenu du message
	 * @return void
	 */
	public function setFlashMessages(string $type, string $message): void
	{
		$this->dispatch('flashMessages', [
			'type' => $type,
			'message' => session($type, $message)
		]);
	}
	
	/**
	 * Définir le champ de tri et la direction de tri. (admin.partiales.table-header.blade.php)
	 *
	 * @param string $name Nom du champ
	 * @return void
	 */
	public function setOrderField(string $name): void
	{
		if ($name === $this->postField) {
			// Basculez entre "ASC" et "DESC" uniquement si le champ de tri est le même
			$this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
		} else {
			// Si le champ de tri est différent, réinitialisez la direction de tri à "ASC"
			$this->postField = $name;
			$this->orderDirection = 'desc';
		}
		
	}
	
	/**
	 * Rendu du composant.
	 *
	 * @param Request $request Requête HTTP
	 * @return view
	 */
	public function render(Request $request): view
	{
		
		$currentPage = $request->session()->get('page', 1);
		
		
		if (session()->has('orderBy') && session()->has('direction')) {
			
			$orderBy = session('orderBy');
			$direction = session('direction');
			$currentPage = session()->put('page', 1);
			
			// Supprimer les valeurs de la session après utilisation
			session()->forget(['orderBy', 'direction']);
		} else {
			$orderBy = $this->postField;
			$direction = $this->orderDirection;
		}
		
		// dd($orderBy, $direction);
		
		$posts = Post::with(['category', 'user'])
			->where('title', 'LIKE', "%$this->search%")
			->orderBy($orderBy, $direction)
			->paginate($this->perpPage, pageName: 'page');
		
		// Rediriger si la page actuelle est différente de la page stockée en session
		$this->redirectIfPageMismatch($posts, $currentPage);
		
		// Retourner la vue avec les posts et la page courante
		return view('livewire.posts-table', ['posts' => $posts, 'page' => $currentPage]);
	}
	
	
	/**
	 * Rediriger si la page actuelle est différente de la page stockée en session
	 *
	 * @param object $categories Données de la catégorie
	 * @param int|null $currentPage Page actuelle
	 * @return mixed
	 */
	private function redirectIfPageMismatch(object $categories, int|null $currentPage): mixed
	{
		$page = $this->updatePagination(true);
		
		if ($currentPage === session('page')) {
			
			session()->put('page', $currentPage);
			
			$page = $currentPage;
			
			
		} elseif ($page === null || $page === 0) {
			session()->put('page', 1);
			$page = 1;
		} else {
			session()->put('page', $page);
		}
		
		if ($page === null || $page === 0) {
			
			return null;
			
		}
		
		
		if (($currentPage === $categories->currentPage()) && ($currentPage > $page)) {
			
			return Redirect::to('admin/post?page=' . $categories->lastPage() . 'orderBy=' . $this->postField, 'direction=' . $this->orderDirection);
			
		}
		
		if ($currentPage != $categories->currentPage()) {
			
			return Redirect::to('admin/post?page=' . $currentPage . '&orderBy=' . $this->postField . '&direction=' . $this->orderDirection);
			
		}
		return null;
	}
	
	/**
	 * Mettre à jour la recherche. (Réinitialiser la pagination à la première page lorsque la recherche est mise à jour)
	 *
	 * @return void
	 */
	public function updatedSearch(): void
	{
		$this->resetPage();
	}
	
}
