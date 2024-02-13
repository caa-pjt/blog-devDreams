<?php

namespace App\Http\Controllers;

use App\Models\Post;

class BlogController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $posts = Post::with('category')->paginate(2);

        return view('blog.index', ['posts' => $posts]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Post $post)
    {
        //
    }


}
