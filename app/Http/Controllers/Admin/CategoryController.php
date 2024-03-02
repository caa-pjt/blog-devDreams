<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryFilterRequest;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use App\Models\Category;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryController extends Controller
{
	
	
	/**
	 * Display a listing of the resource.
	 */
	public function index(Request $request): View
	{
		
		// Récupérer les paramètres de tri
		$page = $request->session()->get('page', 'page') ?? $request->query->get("page", 1);
		$field = $request->session()->get('field', 'name') ?? $request->input('orderDirection', 'created_at');
		$orderDirection = $request->session()->get('orderDirection', 'asc') ?? $request->input('direction', 'desc');
		$method = $request->session()->get('method', false);
		$search = $request->input('search');
		
		// Récupérer les catégories
		$query = Category::orderBy($field, $orderDirection);
		
		if ($search) {
			$query->where('name', 'LIKE', "%$search%");
		}
		
		
		$categories = $query->paginate(10);
		
		return view('admin.category.index', [
			'categories' => $categories,
			'search' => $search,
			'page' => $page,
			'field' => $field,
			'orderDirection' => $orderDirection,
			'method' => $method,
		]);
		
		
	}
	
	/**
	 * Store a newly created resource in storage.
	 */
	public function store(CategoryFilterRequest $request, Category $category): RedirectResponse
	{
		$data = $request->validated();
		$category->create($data);
		
		$request->session()->put('page', 1);
		$request->session()->put('field', 'created_at');
		$request->session()->put('orderDirection', 'desc');
		$request->session()->put('method', 'store');
		
		
		// Rediriger vers la page 1 avec les paramètres de tri corrects
		return redirect()->route("admin.category.index", [
			'page' => 1,
			'field' => 'created_at',
			'orderDirection' => 'desc',
		])->with("success", "La catégorie a bien été créée avec succès !");
	}
	
	/**
	 * Show the form for creating a new resource.
	 */
	public function create(): View
	{
		$category = new Category();
		
		return View("admin.category.create", ['category' => $category]);
	}
	
	/**
	 * Show the form for editing the specified resource.
	 */
	public function edit(Category $category): View
	{
		return view('admin.category.edit', ['category' => $category]);
	}
	
	/**
	 * Update the specified resource in storage.
	 */
	public function update(CategoryFilterRequest $request, Category $category): RedirectResponse
	{
		
		$request->session()->put('page', session()->has('p') ? session()->get('p') : null);
		$request->session()->put('field', $request->query("field"));
		$request->session()->put('orderDirection', $request->query('orderDirection'));
		$request->session()->put('method', 'update');
		
		
		$data = $request->validated();
		$category->update($data);
		return redirect()->route("admin.category.index")->with("success", "catégorie mise à jour !");
	}
	
	/**
	 * Remove the specified resource from storage.
	 */
	public function destroy(Category $category): RedirectResponse
	{
		
		if ($category->id > 0) {
			
			$category->delete();
			$page = request()->query->get("page");
			
			return redirect()->route("admin.category.index", ['page' => $page])
				->with("success", "La catégorie a bien été supprimée !");
		} else {
			return Redirect::back()->withErrors(['error' => 'Impossible de supprimer la catégorie :(']);
		}
	}
}
