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

class PostsTable extends Component
{
	use WithPagination;
	
	#[Url(except: '')]
	public string $search = '';
	#[Url]
	public string $field = 'title';
	#[Url]
	public string $orderDirection = 'asc';
	
	public $post = '';
	public $page;
	public $method;
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
	
	public function postData(Post $post): void
	{
		$this->post = $post;
		
		$this->openModal();
		
	}
	
	public function openModal(): void
	{
		//$this->dispatch('showModal', model: 'post');
		
		//$this->dispatch('showModal', ['model' => 'post']);
		
		$this->dispatch('open-modal', deleteUrl: 'hello');
	}
	
	
	#[On('post-delete')]
	public function deletePost(): void
	{
		
		if ($this->post) {
			
			// Supprimer le post
			$this->post->delete();
			
			// Mettre à jour la pagination après la suppression
			$this->updatePagination();
			
			// Emission des messages flash
			$this->setFlashMessages('success', 'Catégorie supprimée avec succès.');
			
			// return redirect()->route('admin.post.index', ['post' => $this->post, 'page' => 2]);
			
			
			// Réinitialiser la propriété après la suppression
			$this->reset(['post']);
			
		} else {
			
			// Emission des messages flash
			$this->setFlashMessages('error', 'La Catégorie que vous essayez de supprimer n\'existe pas.');
		}
		$this->dispatch('close-modal');
	}
	
	/*
	public function deletePost(): void
	{
		if ($this->post) {
			
			// Supprimer le post
			$this->post->delete();
			
			// Mettre à jour la pagination après la suppression
			$this->updatePagination();
			
			// Emission des messages flash
			$this->setFlashMessages('success', 'Article supprimé avec succès.');
			
			// return redirect()->route('admin.post.index', ['post' => $this->post, 'page' => 2]);
			
			
			// Réinitialiser la propriété deleteId après la suppression
			$this->post = null;
			
			
		} else {
			
			// Emission des messages flash
			$this->setFlashMessages('error', 'Le post que vous essayez de supprimer n\'existe pas.');
		}
		
		// Fermer le modal après la suppression
		// $this->dispatch('close-modal');
	}*/
	
	public function updatePagination(): void
	{
		$count = Post::count();
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
	
	public function closeModal(): void
	{
		$this->dispatch('close-modal');
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
	
	public function render(Request $request): view
	{
		
		$currentPage = $request->session()->get('p', 1);
		
		if (session()->has('orderBy') && session()->has('direction')) {
			
			$orderBy = session('orderBy');
			$direction = session('direction');
			$currentPage = session()->put('p', 1);
			
			// Supprimer les valeurs de la session après utilisation
			session()->forget(['orderBy', 'direction']);
		} else {
			$orderBy = $this->field;
			$direction = $this->orderDirection;
		}
		
		
		// dump('render', $orderBy, session('orderBy'));
		$posts = Post::with(['category', 'user'])
			->where('title', 'LIKE', "%$this->search%")
			->orderBy($orderBy, $direction)
			->paginate($this->perpPage, pageName: 'page');
		
		// Rediriger si la page actuelle est différente de la page stockée en session
		$this->redirectIfPageMismatch($posts, $currentPage);
		
		// Retourner la vue avec les posts et la page courante
		return view('livewire.posts-table', ['posts' => $posts, 'page' => $currentPage]);
	}
	
	private function redirectIfPageMismatch($posts, $currentPage)
	{
		if ($currentPage != $posts->currentPage()) {
			
			return Redirect::to('admin/post?page=' . $currentPage);
			
		}
		
	}
	
	public function updatedSearch(): void
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
	
}
