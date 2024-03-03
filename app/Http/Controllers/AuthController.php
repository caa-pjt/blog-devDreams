<?php

namespace App\Http\Controllers;

use App\Http\Requests\AuthFilterRequest;
use App\Models\User;
use Hash;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AuthController extends Controller
{
	/*
	 * Afficher le formulaire de connexion
	 */
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
	
	
	/**
	 * Gérer une tentative d'authentification.
	 *
	 * @param AuthFilterRequest $request
	 * @return RedirectResponse|view
	 */
	public function doLogin(AuthFilterRequest $request): RedirectResponse|view
	{
		$credentials = $request->validated();
		
		
		if (Auth::attempt($credentials)) {
			$request->session()->regenerate();
			return redirect()->intended(route('admin.dashboard'));
		}
		
		return redirect()->route('login')->withErrors(
			['email' => "Email invalid"]
		)->onlyInput("email");
		
		
	}
	
	public function login(): view
	{
		return view("auth.login");
	}
	
	/**
	 * Créer un utilisateur avec un jeton.
	 *
	 * @param string $token
	 * @return RedirectResponse
	 */
	public function createUser(string $token): RedirectResponse
	{
		if ($token !== '1234') {
			abort(403, 'Token invalide.');
		}
		
		$name = 'John Doe';
		$email = 'john@doe.fr';
		$password = 'password';
		
		$user = User::where('email', $email)->get();
		
		if ($user->isEmpty()) {
			User::create([
				'name' => $name,
				'email' => $email,
				'password' => Hash::make($password),
				'remember_token' => Str::random(10)
			]);
		}
		
		
		// Tentative de connexion de l'utilisateur
		if (Auth::attempt(['email' => $email, 'password' => $password])) {
			// Si la connexion réussit, regénérez la session et redirigez vers le tableau de bord
			Session::regenerate();
			// return Redirect::intended(route('admin.dashboard'));
			return Redirect::route('home')->with('success', 'Utilisateur créé et connecté.');
		}
		
		// Si la connexion échoue, redirigez vers la page de connexion avec un message d'erreur
		return Redirect::route('login')->withErrors(['email' => 'Impossible de se connecter.'])->withInput();
	}
}
