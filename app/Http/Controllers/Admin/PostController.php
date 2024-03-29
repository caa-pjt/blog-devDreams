<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostFilterRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
	protected int $page = 1;
	
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): view
	{
		// Récupérer les paramètres de tri
		$page = $request->session()->get('page', 'page') ?? $request->query->get("page", 1);
		$field = $request->session()->get('postField', 'title') ?? $request->input('postField', 'created_at');
		$orderDirection = $request->session()->get('orderDirection', 'asc') ?? $request->input('direction', 'asc');
		$method = $request->session()->get('method', false);
		$search = $request->input('search');
		
		
		// dump($page, $field, $orderDirection, $method, $search);
		
		$query = Post::with(['category', 'user']);
		
		if ($search) {
			$query->where('title', 'LIKE', "%$search%");
		}
		
		$query->orderBy($field, $orderDirection);
		
		$posts = $query->paginate(10);
		
		return view('admin.post.index', [
			'posts' => $posts,
			'search' => $search,
			'field' => $field,
			'orderDirection' => $orderDirection,
			'page' => $page,
			'method' => $method,
		]);
	}
	
	/**
	 * Store a newly created resource in storage.
	 */
	public function store(PostFilterRequest $request, Post $post): RedirectResponse
	{
		
		$post->create($this->setPostData($post, $request));
		
		$request->session()->put('page', 1);
		$request->session()->put('postField', 'created_at');
		$request->session()->put('orderDirection', 'desc');
		$request->session()->put('method', 'store');
		
		return redirect()->route("admin.post.index", [
			'page' => 1,
			'postField' => 'created_at',
			'orderDirection' => 'desc',
		])->with(["success", "Le post à bien été créé !", "orderBy" => "created_at", "direction" => "asc"]);
	}
	
	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): view
	{
		$post = new Post();
		$categories = Category::all("id", "name");
		return view('admin.post.create', ['post' => $post, 'categories' => $categories]);
	}
	
	/**
	 * Don't forget to link the storage with the specific php artisan commande : storage:link
	 *
	 * @param Post $post
	 * @param PostFilterRequest $request
	 * @return array Post with image if exist || errors
	 */
	private function setPostData(Post $post, PostFilterRequest $request): array
	{
		$data = $request->validated();
		$image = $request->validated('image');
		
		// Si il y a des erreurs de validation, renvoi des erreurs
		if (!$image || !$image->isValid()) {
			return $data;
		}
		
		// Supprimer l'ancienne image si elle existe
		if ($post->image) {
			Storage::disk('public')->delete($post->image);
		}
		
		// Enregistrer la nouvelle image dans le storage
		$data['image'] = $image->store('images/' . date('Y') . '/' . date('m'), 'public');
		
		// renvoi des données
		return $data;
	}
	
	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Post $post): view
	{
		$categories = Category::all("id", "name");
		return view('admin.post.edit', ['post' => $post, 'categories' => $categories]);
	}
	
	
	/**
	 * Update the specified resource in storage.
	 */
	public function update(PostFilterRequest $request, Post $post): RedirectResponse
	{
		$request->session()->put('page', session()->has('page') ? session()->get('page') : null);
		$request->session()->put('postField', $request->query("field"));
		$request->session()->put('orderDirection', $request->query('orderDirection'));
		$request->session()->put('method', 'update');
		
		
		$post->update($this->setPostData($post, $request));
		return redirect()->route("admin.post.index")->with("success", "Article mis à jour !");
	}
	
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Post $post): RedirectResponse
	{
		
		if ($post->id > 0) {
			
			// Supprimer l'article
			if ($post->image) {
				Storage::disk('public')->delete($post->image);
			}
			
			$post->delete();
			$page = request()->query->get("page");
			
			return redirect()->route("admin.post.index", ['page' => $page])
				->with("success", "L'article a bien été supprimé !");
		} else {
			return Redirect::back()->with('error', 'Impossible de supprimer l\'article :(');
		}
	}
}
