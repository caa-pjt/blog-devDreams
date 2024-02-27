<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Str;

class Category extends Model
{
	use HasFactory;
	
	protected $fillable = ["name"];
	
	/**
	 * Retourne la liste des articles de la catégorie
	 * @return HasMany
	 */
	public function post(): HasMany
	{
		return $this->hasMany(Post::class);
	}
	
	/**
	 * Retourne le nom de la catégorie en majuscule
	 * @return string
	 */
	public function getName(): string
	{
		return Str::title($this->name);
	}
}
