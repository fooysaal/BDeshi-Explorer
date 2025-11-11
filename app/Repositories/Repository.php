<?php

namespace App\Repositories;

use Illuminate\Database\Eloquent\Model;

abstract class Repository implements IRepository
{
	public function changeStatus(Model $model, $filedName = 'is_active')
	{
		$model->$filedName = !$model->$filedName;
		$model->update();
		return $model;
	}

	public function destroy(Model $model)
	{
		return $model->delete();
	}

	public function restore(Model $model, $id)
	{
		$model->withTrashed()->findOrFail($id)->restore();
	}

	public function delete(Model $model, $id)
	{
		$model->withTrashed()->findOrFail($id)->forceDelete();
	}
}
