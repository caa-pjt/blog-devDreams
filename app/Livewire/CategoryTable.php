<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
	use WithPagination;
	
	#[Url(except: '')]
	public string $search = '';
	
	protected $paginationTheme = 'bootstrap';
	
	public function render()
	{
		$categories = Category::where('name', 'LIKE', "%$this->search%")
			->orderBy('name', 'asc')->paginate(10);
		
		return view('livewire.category-table', ['categories' => $categories]);
	}
	
	
	public function updatedSearch()
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
