<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Post extends Model
{
    use HasFactory;

    protected $fillable = ["title", "slug", "content", "category_id", "published"];

    public function category(): BelongsTo
    {
        return $this->belongsTo(Category::class);
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
}
