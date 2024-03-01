<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\WithPagination;

class BlogIndex extends Component
{
	use WithPagination;
	
	public $cat;
	protected $paginationTheme = 'bootstrap';
	
	protected $listeners = ['loadPost'];
	protected $queryString = [
		'cat' => ['except' => '']
	];
	
	public function render(): View
	{
		$postsQuery = Post::with(['category', 'user'])->orderBy("created_at", "desc")->published();
		
		if ($this->cat) {
			$postsQuery->whereHas('category', function ($query) {
				$query->where('name', $this->cat);
			});
		}
		
		$posts = $postsQuery->paginate(5);
		
		$categories = Category::with('post')->has('post')->pluck('name')->toArray();
		
		return view('livewire.blog-index', ['posts' => $posts, 'categories' => $categories]);
	}
	
	public function filterByCategory($categoryName): void
	{
		$this->cat = $categoryName;
		$this->resetPage();
	}
	
	
	public function redirectToPost($slug, $id)
	{
		return redirect()->route('show', ['slug' => $slug, 'id' => $id]);
	}
}