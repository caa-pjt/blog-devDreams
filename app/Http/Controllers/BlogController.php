<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class BlogController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): view
	{
		$categoryName = $request->input('cat');
		$posts = Post::with(['category', 'user'])->published();
		
		if ($categoryName) {
			$posts->whereHas('category', function ($query) use ($categoryName) {
				$query->where('name', $categoryName);
			});
		}
		
		$posts = $posts->paginate(10);
		
		$categories = Category::with('post')->has('post')->pluck('name')->toArray();
		
		return view('blog.index', ['posts' => $posts, 'categories' => $categories]);
	}
	
	/**
	 * Display the specified resource.
	 */
	public function show(string $slug, string $id): view|RedirectResponse
	{
		
		$post = Post::with(['category', 'user'])->findOrFail($id);
		$relatedPosts = Post::where('category_id', $post->category_id)
			->published()
			->whereNotIn('id', [$post->id])
			->inRandomOrder()
			->limit(4)
			->get();
		
		if ($slug != $post->slug) {
			return redirect()->route('show', ['slug' => $post->slug, 'id' => $post->id]);
		}
		return view('blog.show', ['post' => $post, 'relatedPosts' => $relatedPosts]);
	}
	
	
}
