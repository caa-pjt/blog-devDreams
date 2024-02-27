<?php

namespace App\Livewire;

use App\Models\Category;
use Illuminate\View\View;
use Livewire\Attributes\Url;
use Livewire\Component;
use Livewire\WithPagination;

class CategoryTable extends Component
{
	use WithPagination;
	
	#[Url(except: '')]
	public string $search = '';
	
	protected $paginationTheme = 'bootstrap';
	
	/**
	 * Permet de définir les propriétés qui peuvent être mises à jour depuis la vue
	 * @return View
	 */
	public function render(): View
	{
		$categories = Category::where('name', 'LIKE', "%$this->search%")
			->orderBy('name', 'asc')->paginate(10);
		
		return view('livewire.category-table', ['categories' => $categories]);
	}
	
	
	public function updatedSearch(): void
	{
		// Réinitialiser la pagination à la première page lorsque la recherche est mise à jour
		$this->resetPage();
	}
}
