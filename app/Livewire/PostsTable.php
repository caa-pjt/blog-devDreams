<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\View\View;
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
	
	protected $paginationTheme = 'bootstrap';
	
	public function mount(Request $request): void
	{
		$this->field = $request->input('order', 'created_at');
		$this->orderDirection = $request->input('direction', 'desc');
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
	
	
	public function render(): View
	{
		
		$posts = Post::with(['category', 'user'])
			->where('title', 'LIKE', "%$this->search%")
			->orderBy($this->field, $this->orderDirection)
			->paginate(10);
		
		return view('livewire.posts-table', ['posts' => $posts]);
	}
	
	public function updatedSearch(): void
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
