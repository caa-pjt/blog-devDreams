<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFilterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
	public function login(): view
	{
		return view("auth.login");
	}
	
	public function doLogin(AuthFilterRequest $request): RedirectResponse|view
	{
		$user = $request->validated();
		if (Auth::attempt($user)) {
			$request->session()->regenerate();
			return redirect()->intended(route('admin.dashboard'));
		}
		
		return redirect()->route('login')->withErrors(
			['email' => "Email invalid"]
		)->onlyInput("email");
		
		
	}
	
	public function logout(): RedirectResponse
	{
		Auth::logout();
		return redirect()->route('home');
	}
}
