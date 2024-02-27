<?php

namespace App\Http\Requests\Admin;

use Auth;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class PostFilterRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 */
	public function authorize(): bool
	{
		return true;
	}
	
	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array<string, ValidationRule|array<mixed>|string>
	 */
	public function rules(): array
	{
		$postId = $this->post->id ?? null;
		
		return [
			"title" => ['required', 'min:3', Rule::unique('posts')->ignore($this->post)],
			"slug" => ["required", "min:5", "regex:/^[0-9a-z\-]+$/", Rule::unique('posts')->ignore($this->post)],
			"content" => ['required', 'min:20'],
			"category_id" => ["nullable", "exists:categories,id"],
			"published" => ["required", "boolean"],
			'image' => ['image', 'mimes:jpeg,png,jpg', 'max:2048'],
			'user_id' => ['required', 'integer'],
		];
	}
	
	public function prepareForValidation(): void
	{
		$this->merge([
			'slug' => $this->input('slug') ?: Str::slug($this->input('title')),
			"published" => ($this->input('published') == 1) ? 1 : 0,
			'user_id' => Auth::id(),
		]);
	}
}
