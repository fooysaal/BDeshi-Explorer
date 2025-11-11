<?php

namespace App\Repositories\App\Cms;

use App\Helpers\FileUploader;
use App\Models\App\Cms\Widget;
use App\Repositories\Repository;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;

class WidgetRepository extends Repository
{
	// public Model $model;
	// function __construct(Model $model)
	// {
	// 	$this->model = $model;
	// }

	public function all()
	{
		return Widget::withTrashed()->orderBy('created_at', 'desc')->get();
	}
	
	public function create(Request $request)
	{
		$widget = new Widget;
		$widgetTitle = $request->title;
		$widget->title = $widgetTitle;
		$widget->contents = $request->contents;
		$widget->publish_from = $request->publish_from;
		$widget->publish_to = $request->publish_to;
		$widget->slug = str_slug($widgetTitle);
		$widget->is_active = 1;

		$widget->save();
	}

	public function update(Request $request, Model $model)
	{
		$statusButtonKey = config('app-view.statusButton.name');
		if ($request->$statusButtonKey === config('app-view.statusButton.value')) {
			return $this->changeStatus($model);
		}

		$model->title = $request->title;
		$model->contents = $request->contents;
		$model->publish_from = $request->publish_from;
		$model->publish_to = $request->publish_to;
		$model->is_active = 1;

		$model->update();
	}

	public function findById($id)
	{
	}
}
