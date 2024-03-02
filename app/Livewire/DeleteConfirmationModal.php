<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class DeleteConfirmationModal extends Component
{
	public $model = '';
	
	#[On('showModal')]
	public function show($model = ''): void
	{
		$this->model = $model;
		
		$this->dispatch('open-modal');
	}
	
	public function deleteItem(): void
	{
		// Appel de la méthode delete du composant parent selon le modèle
		$this->dispatch($this->model . '-delete');
		
		$this->dispatch('closeModal');
	}
	
	#[On('closeModal')]
	public function closeModal(): void
	{
		$this->reset(['model']);
		
		$this->dispatch('close-modal');
	}
	
	public function render(): view
	{
		return view('livewire.delete-confirmation-modal');
	}
}
