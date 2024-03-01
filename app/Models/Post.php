<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class Post extends Model
{
	use HasFactory;
	
	public $timestamps = true;
	
	protected $fillable = ["title", "slug", "content", "category_id", "published", "image", "user_id"];
	
	/**
	 * Retourne la catégorie de l'article
	 * @return BelongsTo
	 */
	public function category(): BelongsTo
	{
		return $this->belongsTo(Category::class);
	}
	
	/**
	 * Retourne l'utilisateur de l'article
	 * @return BelongsTo
	 */
	public function user(): BelongsTo
	{
		return $this->belongsTo(User::class);
	}
	
	
	/**
	 * Retourne un extrait de l'article
	 *
	 * @param $length -> Longer de l'extrait
	 * @return string
	 */
	public function excerpt($length = 100): string
	{
		return Str::limit($this->content, $length);
	}
	
	/**
	 * Retourne l'URL de l'image
	 * @return string
	 */
	public function imageUrl(): string
	{
		return Storage::disk('public')->url($this->image);
	}
	
	/**
	 * Retourne le nom de l'article en majuscule
	 * @return string
	 */
	public function getTitle(): string
	{
		return Str::title($this->title);
	}
	
	/**
	 * Retourne la liste des articles qui sont "published"
	 * @param $query
	 * @return mixed
	 */
	public function scopePublished($query)
	{
		return $query->where('published', true);
	}
}
