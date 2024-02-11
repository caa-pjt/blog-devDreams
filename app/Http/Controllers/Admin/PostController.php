<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostFilterRequest;
use App\Models\Category;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $posts = Post::with('category')->orderBy("created_at", "desc")->paginate(10);
        return view('admin.index', ['posts' => $posts]);
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
     * Store a newly created resource in storage.
     */
    public function store(PostFilterRequest $request, Post $post): RedirectResponse
    {
        $data = $request->validated();
        $post->create($data);

        return redirect()->route("admin.post.index")
            ->with("success", "Le post à bien été créé !");
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
        $data = $request->validated();
        $post->update($data);
       return redirect()->route("admin.post.index")->with("success", "Article mis à jour !");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Post $post): RedirectResponse
    {

        if ($post) {

            $post->delete();
            $page = request()->query->get("page");

            return redirect()->route("admin.post.index", ['page' => $page])
                ->with("success", "L'article a bien été supprimé !");
        } else {
            return Redirect::back()->withErrors(['error' => 'Impossible de supprimer l\'article :(']);
        }
    }
}
