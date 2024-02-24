<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Post;
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
	
	public function render()
	{
		$postsQuery = Post::with('category')->published();
		
		if ($this->cat) {
			$postsQuery->whereHas('category', function ($query) {
				$query->where('name', $this->cat);
			});
		}
		
		$posts = $postsQuery->paginate(5);
		$categories = Category::all();
		
		return view('livewire.blog-index', ['posts' => $posts, 'categories' => $categories]);
	}
	
	public function filterByCategory($categoryName)
	{
		$this->cat = $categoryName;
		$this->resetPage();
	}
	
	
	public function redirectToPost($slug, $id)
	{
		return redirect()->route('show', ['slug' => $slug, 'id' => $id]);
	}
}