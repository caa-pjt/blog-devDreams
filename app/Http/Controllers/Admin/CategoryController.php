<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CategoryFilterRequest;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;
use App\Models\Category;
use Symfony\Component\HttpFoundation\RedirectResponse;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $categories = Category::orderBy("created_at", "desc")->paginate(15);
        return View("admin.category.index", ['categories' => $categories]);

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        $category = new Category();

        return View("admin.category.create", ['category' => $category]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(CategoryFilterRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $category->create($data);

        return redirect()->route("admin.category.index")
            ->with("success", "La catégorie à bien été créé !");
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category): view
    {
        return view('admin.category.edit', ['category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(CategoryFilterRequest $request, Category $category): RedirectResponse
    {
        $data = $request->validated();
        $category->update($data);
        return redirect()->route("admin.category.index")->with("success", "catégorie mise à jour !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category): RedirectResponse
    {

        if ($category) {

            $category->delete();
            $page = request()->query->get("page");

            return redirect()->route("admin.category.index", ['page' => $page])
                ->with("success", "La catégorie a bien été supprimée !");
        } else {
            return Redirect::back()->withErrors(['error' => 'Impossible de supprimer la catégorie :(']);
        }
    }
}
