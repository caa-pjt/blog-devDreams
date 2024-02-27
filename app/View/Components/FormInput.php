<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class FormInput extends Component
{
	/**
	 * Label de l'input
	 * @var string
	 */
	public string $label;
	/**
	 * Nom du champ de l'input
	 * @var string
	 */
	public string $name;
	/**
	 * Valeur de l'input
	 * @var mixed|string
	 */
	public mixed $value;
	/**
	 * Type de l'input
	 * Types supportés : text, textarea, checkbox, file, select
	 * @var string
	 */
	public string $type;
	/**
	 * Placeholder le l'input
	 * @var string
	 */
	public string $placeholder;
	/**
	 * Class css du container
	 * @var string
	 */
	public string $class;
	/**
	 * Option de l'input de type select (seulement applicable pour l'input de type select)
	 * @var array
	 */
	public array $options;
	
	/**
	 * Create a new component instance.
	 *
	 * @param string $label Le libellé de l'entrée.
	 * @param string $name Le nom de l'entrée.
	 * @param string|null $value La valeur de l'entrée.
	 * @param string $type Le type de l'entrée (par défaut : 'text').
	 * @param string $placeholder Le texte d'aide pour l'entrée (par défaut : vide).
	 * @param string $class Les classes CSS pour le conteneur de l'entrée (par défaut : 'row g-1 mb-3').
	 * @param array $options Les options pour l'entrée de sélection (applicable uniquement pour le type 'select') (par défaut : []).
	 *
	 * @return void
	 */
	public function __construct(
		string $label,
		string $name,
		mixed  $value = '',
		string $type = 'text',
		string $placeholder = '',
		string $class = 'row g-1 mb-3',
		array  $options = [],
	)
	{
		$this->label = $label;
		$this->name = $name;
		
		
		$this->value = is_array($value) ? [$value][0] : $value;
		
		$this->type = $type;
		
		if (empty($placeholder)) {
			$placeholder = ucfirst($this->name);
		}
		
		$this->placeholder = $placeholder;
		$this->class = $class;
		
		$this->options = $options;
	}
	
	/**
	 * Get the view / contents that represent the component.
	 */
	public function render(): View|Closure|string
	{
		return view('components.form-input');
	}
}
