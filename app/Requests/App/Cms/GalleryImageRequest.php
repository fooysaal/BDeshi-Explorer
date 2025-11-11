<?php

namespace App\Http\Requests\App\Cms;

use Illuminate\Foundation\Http\FormRequest;

class GalleryImageRequest extends FormRequest
{
	/**
	 * Determine if the user is authorized to make this request.
	 *
	 * @return bool
	 */
	public function authorize()
	{
		return true;
	}

	/**
	 * Get the validation rules that apply to the request.
	 *
	 * @return array
	 */
	public function rules()
	{
		return [
			'galleryImages.*' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:2048',
		];
	}
}
