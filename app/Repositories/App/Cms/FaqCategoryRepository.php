<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\FaqCategory;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class FaqCategoryRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return FaqCategory::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$faqCategory = new FaqCategory;
		$faqCategoryName = $request->name;
		$faqCategory->name = $faqCategoryName;
		$faqCategory->parent_id = $request->parent_id;
		$faqCategory->code = $request->code;
		$faqCategory->description = $request->description;
		// $faqCategory->slug = str_slug($brandName);
		$faqCategory->is_active = 1;

		$faqCategory->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$faqCategoryName = $request->name;
		$model->name = $faqCategoryName;
		$model->parent_id = $request->parent_id;
		$model->code = $request->code;
		$model->description = $request->description;
		// $model->slug = str_slug($faqCategoryName);
		$model->is_active = 1;

		$model->update();
	}

	public function findById($id)
	{
	}
}
