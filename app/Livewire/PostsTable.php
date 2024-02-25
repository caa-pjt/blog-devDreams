<?php

namespace App\Livewire;

use App\Models\Post;
use Livewire\Component;
use Livewire\WithPagination;
use PhpParser\Node\Scalar\String_;

class PostsTable extends Component
{
	use WithPagination;
	
	public string $search = '';
	
	protected $paginationTheme = 'bootstrap';
	
	// Récupérer la valeur de recherche à partir de l'URL si elle existe
	protected $queryString = [
		'search' => ['except' => '']
	];
	
	
	public function render()
	{
		
		$posts = Post::with(['category', 'user'])
			->where('title', 'LIKE', "%$this->search%")
			->orderBy("created_at", "desc")
			->paginate(10);
		
		return view('livewire.posts-table', ['posts' => $posts]);
	}
	
	public function updatedSearch()
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
