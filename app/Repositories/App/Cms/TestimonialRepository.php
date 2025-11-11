<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\Testimonial;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class TestimonialRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return Testimonial::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$testimonial = new Testimonial;
		$personName = $request->person_name;
		$testimonial->person_name = $personName;
		$testimonial->testimonial = $request->testimonial;
		$testimonial->designation = $request->designation;
		$testimonial->order = $request->order;
		$testimonial->feedback_score = $request->feedback_score;
		$testimonial->person_about = $request->person_about;
		// $testimonial->slug = str_slug($brandName);
		$testimonial->is_active = 1;

		if ($request->hasFile('personImage')) {
			$testimonial->person_image = FileUploader::uploadSingleFile($request->file('personImage'), 'testimonials');;
		}

		$testimonial->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$personName = $request->person_name;
		$model->person_name = $personName;
		$model->testimonial = $request->testimonial;
		$model->designation = $request->designation;
		$model->person_about = $request->person_about;
		$model->order = $request->order;
		$model->feedback_score = $request->feedback_score;
		$model->person_about = $request->person_about;
		// $model->slug = str_slug($personName);
		$model->is_active = 1;

		if ($request->hasFile('personImage')) {
			fileExistAndDelete($model->person_image, 'testimonials');
			$model->person_image = FileUploader::uploadSingleFile($request->file('personImage'), 'testimonials');;
		}

		$model->update();
	}

	public function findById($id)
	{
	}
}
