<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\PostFilterRequest;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use Illuminate\View\View;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): view
    {
        $posts = Post::paginate(10);
        return view('admin.index', ['posts' => $posts]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(): view
    {
        $post = new Post();

        return view('admin.create', ['post' => $post]);
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
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Post $post): view
    {
        return view('admin.edit', ['post' => $post]);
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

            return redirect()->route("admin.post.index")
                ->with("success", "L'article a bien été supprimé !");
        } else {
            return Redirect::back()->withErrors(['error' => 'Impossible de supprimer l\'article :(']);
        }
    }
}
