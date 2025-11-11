<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\PageTemplate;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class PageTemplateRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return PageTemplate::orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$pageTemplate = new PageTemplate;
		$pageTemplate->name = $request->name;
		$pageTemplate->description = $request->description;
		$pageTemplate->is_active = 1;

		$pageTemplate->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->name = $request->name;
		$model->description = $request->description;
		$model->is_active = 1;
		
		$model->update();
	}

	public function findById($id)
	{
	}
}
