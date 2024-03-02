<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Attributes\Url;
use Illuminate\Support\Facades\Session;
use Livewire\Component;
use Livewire\WithPagination;

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
	 * @param $field
	 * @param $orderDirection
	 * @param $page
	 * @param $method
	 * @return void
	 */
	public function mount($field, $orderDirection, $page, $method): void
	{
		$this->field = $field;
		$this->orderDirection = $orderDirection;
		$this->page = $page;
		$this->method = $method;
		
		if ($this->method !== false) {
			// dump('method : ' . $this->method);
			$this->updatedPage($this->page);
			
			// Session::forget('method');
		}
	}
	
	public function updatedPage($p = null): void
	{
		// dump($p);
		if ($p !== null) {
			// Enregistrer la page actuelle dans la session
			// dump('updatedPage $p xxx : ' . $p);
			Session::put('p', $p);
		} else {
			// Enregistrer la page actuelle dans la session
			// dump('updatedPage $this->page : ' . $this->page);
			Session::put('p', $this->getPage());
		}
	}
	
	public function postData(Category $category): void
	{
		
		$this->category = $category;
		
		$this->openModal();
		
	}
	
	public function openModal(): void
	{
		$this->dispatch('showModal', model: 'category');
	}
	
	#[On('category-delete')]
	public function deleteData(): void
	{
		
		if ($this->category) {
			
			// Supprimer le post
			$this->category->delete();
			
			// Mettre à jour la pagination après la suppression
			$this->updatePagination();
			
			// Emission des messages flash
			$this->setFlashMessages('success', 'Catégorie supprimée avec succès.');
			
			// return redirect()->route('admin.post.index', ['post' => $this->post, 'page' => 2]);
			
			
			// Réinitialiser la propriété après la suppression
			$this->reset(['category']);
			
		} else {
			
			// Emission des messages flash
			$this->setFlashMessages('error', 'La Catégorie que vous essayez de supprimer n\'existe pas.');
		}
		
	}
	
	public function updatePagination(): void
	{
		$count = Category::count();
		$this->page = $this->getPage();
		$nbrPages = (int)ceil($count / $this->perpPage);
		
		if ($this->page > $nbrPages) {
			$this->setPage($nbrPages);
		}
		
	}
	
	public function setFlashMessages(string $type, string $message): void
	{
		$this->dispatch('flashMessages', [
			'type' => $type,
			'message' => session($type, $message)
		]);
	}
	
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
		
		// dump('currentPage : ' . $currentPage);
		
		$orderBy = $this->field;
		$direction = $this->orderDirection;
		
		$categories = Category::where('name', 'LIKE', "%$this->search%")
			->orderBy($orderBy, $direction)
			->paginate($this->perpPage);
		
		
		// $categories = Category::where('name', 'LIKE', "%$this->search%")->orderBy('name', 'asc')->paginate($this->perpPage);
		
		
		// Rediriger si la page actuelle est différente de la page stockée en session
		$this->redirectIfPageMismatch($categories, $currentPage);
		
		// Retourner la vue avec les posts et la page courante
		return view('livewire.category-table', ['categories' => $categories]);
		
	}
	
	private function redirectIfPageMismatch($categories, $currentPage)
	{
		
		if ($currentPage != $categories->currentPage()) {
			
			dump('redirectIfPageMismatch');
			return Redirect::to('admin/category?page=' . $currentPage);
			
		}
		
		
	}
	
	public function updatedSearch(): void
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
