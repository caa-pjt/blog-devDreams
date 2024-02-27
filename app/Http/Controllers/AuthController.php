<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFilterRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthController extends Controller
{
	/*
	 * Afficher le formulaire de connexion
	 */
	public function login(): view
	{
		return view("auth.login");
	}
	
	/**
	 * Gérer une tentative d'authentification.
	 *
	 * @param AuthFilterRequest $request
	 * @return RedirectResponse|view
	 */
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
	
	/**
	 * Déconnecter l'utilisateur.
	 *
	 * @return RedirectResponse
	 */
	public function logout(): RedirectResponse
	{
		Auth::logout();
		return redirect()->route('home');
	}
}
