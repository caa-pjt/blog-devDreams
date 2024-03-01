<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\View\View;
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
	public string $deleteUrl = '';
	public $page = null;
	protected $paginationTheme = 'bootstrap';
	private int $perpPage = 10;
	
	public function mount(Request $request): void
	{
		$this->field = $request->input('order', 'created_at');
		$this->orderDirection = $request->input('direction', 'desc');
	}
	
	public function postData(Post $post, $deleteUrl): void
	{
		$this->post = $post;
		$this->deleteUrl = $deleteUrl;
		
		$this->openModal();
		
	}
	
	public function openModal(): void
	{
		$this->dispatch('open-modal', deleteUrl: $this->deleteUrl);
	}
	
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
		$this->dispatch('close-modal');
	}
	
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
	
	public function updatedPage()
	{
		// Enregistrer la page actuelle dans la session
		Session::put('p', $this->getPage());
	}
	
}
