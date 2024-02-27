<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
	public function index(): View
	{
		
		$publishedPostCount = Post::where('published', true)->count();
		$unpublishedPostCount = Post::where('published', false)->count();
		$category = Category::count();
		$user = User::first(['name', 'email'])->toArray();
		
		return view('admin.dashboard', [
			'publishedPostCount' => $publishedPostCount,
			'unpublishedPostCount' => $unpublishedPostCount,
			'category' => $category, 'user' => $user
		]);
	}
}
