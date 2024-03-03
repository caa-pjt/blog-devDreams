<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;
use Redirect;

class CategoryTable extends Component
{
	use WithPagination;
	
	#[Url(except: '')]
	public string $search = '';
	#[Url]
	public string $field = 'name';
	#[Url]
	public string $orderDirection = 'asc';
	
	
	public $page;
	
	public $method;
	
	public $category = '';
	
	
	public int $perpPage = 10;
	protected $paginationTheme = 'bootstrap';
	
	
	/**
	 * Montage du composant avec les paramètres donnés.
	 *
	 * @param string $field Champ pour le tri
	 * @param string $orderDirection Direction de tri
	 * @param int $page Numéro de page actuel
	 * @param string $method Méthode pour la pagination
	 * @return void
	 */
	public function mount(string $field, string $orderDirection, mixed $page, mixed $method): void
	{
		$this->field = $field;
		$this->orderDirection = $orderDirection;
		$this->page = $page;
		$this->method = $method;
		
		if ($this->method !== false) {
			$this->updatedPage($this->page);
		}
	}
	
	/**
	 * Récupérer la page actuelle.
	 *
	 * @param null $p
	 * @return void
	 */
	public function updatedPage($p = null): void
	{
		if ($p !== null) {
			// Enregistrer la page actuelle dans la session
			Session::put('p', $p);
		} else {
			// Enregistrer la page actuelle dans la session
			Session::put('p', $this->getPage());
		}
	}
	
	/**
	 * Définir les données de la catégorie.
	 *
	 * @param Category $category Données de la catégorie
	 * @return void
	 */
	public function postData(Category $category): void
	{
		
		$this->category = $category;
		
		$this->openModal();
		
	}
	
	/**
	 * Ouvrir le modal pour la suppression de la catégorie. (composant livewire)
	 *
	 * @return void
	 */
	public function openModal(): void
	{
		$this->dispatch('showModal', model: 'category');
	}
	
	/**
	 * Fermer le modal pour la suppression de la catégorie. (composant livewire)
	 *
	 * @return void
	 */
	#[On('category-delete')]
	public function deleteData(): void
	{
		
		if ($this->category->exists()) {
			
			// Supprimer le post
			$this->category->delete();
			
			// Mettre à jour la pagination après la suppression
			$this->updatePagination();
			
			// Emission des messages flash
			$this->setFlashMessages('success', 'Catégorie supprimée avec succès.');
			
			
			// Réinitialiser la propriété après la suppression
			$this->reset(['category']);
			
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
		$count = Category::count();
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
		if ($name === $this->field) {
			// Basculez entre "ASC" et "DESC" uniquement si le champ de tri est le même
			$this->orderDirection = $this->orderDirection === 'asc' ? 'desc' : 'asc';
		} else {
			// Si le champ de tri est différent, réinitialisez la direction de tri à "ASC"
			$this->field = $name;
			$this->orderDirection = 'desc';
		}
		
	}
	
	/**
	 * Permet de définir les propriétés qui peuvent être mises à jour depuis la vue
	 * @param Request $request
	 * @return View
	 */
	public function render(Request $request): view
	{
		$currentPage = $request->session()->get('p', 1);
		
		$orderBy = $this->field;
		$direction = $this->orderDirection;
		
		$categories = Category::where('name', 'LIKE', "%$this->search%")
			->orderBy($orderBy, $direction)
			->paginate($this->perpPage);
		
		
		// Rediriger si la page actuelle est différente de la page stockée en session
		$this->redirectIfPageMismatch($categories, $currentPage);
		
		// Retourner la vue avec les posts et la page courante
		return view('livewire.category-table', ['categories' => $categories]);
		
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
			
			return Redirect::to('admin/category?page=' . $categories->lastPage() . 'orderBy=' . $this->field, 'direction=' . $this->orderDirection);
			
		}
		
		if ($currentPage != $categories->currentPage()) {
			
			return Redirect::to('admin/category?page=' . $currentPage . '&orderBy=' . $this->field . '&direction=' .
				$this->orderDirection);
			
		}
		return null;
	}
	
	/**
	 * Mettre à jour la recherche lorsque la valeur de recherche est modifiée
	 *
	 * @return void
	 */
	public function updatedSearch(): void
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
