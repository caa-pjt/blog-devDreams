<?php

namespace App\Livewire;

use App\Models\Post;
use Illuminate\Http\Request;
use Livewire\Component;
use Livewire\WithPagination;

class PostsTable extends Component
{
	use WithPagination;
	
	public string $search = '';
	public string $field = 'title';
	public string $orderDirection = 'asc';
	
	protected $paginationTheme = 'bootstrap';
	
	// Récupérer la valeur de recherche à partir de l'URL si elle existe
	protected $queryString = [
		'search' => ['except' => ''],
	];
	
	public function mount(Request $request)
	{
		$this->field = $request->input('order', 'title');
		$this->orderDirection = $request->input('direction', 'desc');
	}
	
	public function setOrderField(string $name)
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
	
	
	public function render()
	{
		
		$posts = Post::with(['category', 'user'])
			->where('title', 'LIKE', "%$this->search%")
			->orderBy($this->field, $this->orderDirection)
			->paginate(10);
		
		return view('livewire.posts-table', ['posts' => $posts]);
	}
	
	public function updatedSearch()
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
