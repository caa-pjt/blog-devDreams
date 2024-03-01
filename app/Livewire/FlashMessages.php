<?php

namespace App\Livewire;

use Illuminate\View\View;
use Livewire\Attributes\On;
use Livewire\Component;

class FlashMessages extends Component
{
	public $flash;
	
	#[On('flashMessages')]
	public function updateFlash($flash = null)
	{
		$this->flash = $flash;
		session()->flash($this->flash['type'], $this->flash['message']);
	}
	
	
	public function render(): View
	{
		return view('livewire.flash-messages');
	}
}
