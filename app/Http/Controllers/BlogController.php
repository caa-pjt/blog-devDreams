<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\Request;

class BlogController extends Controller
{
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request)
	{
		$categoryName = $request->input('cat');
		$posts = Post::with(['category', 'user'])->published();
		
		if ($categoryName) {
			$posts->whereHas('category', function ($query) use ($categoryName) {
				$query->where('name', $categoryName);
			});
		}
		
		$posts = $posts->paginate(5);
		$categories = Category::all();
		
		return view('blog.index', ['posts' => $posts, 'categories' => $categories]);
	}
	
	/**
	 * Display the specified resource.
	 */
	public function show(string $slug, string $id)
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
