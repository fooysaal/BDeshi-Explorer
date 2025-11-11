<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Model;

interface IRepository
{
	public function all();
	public function create(Request $request);
	public function update(Request $request, Model $model);
	public function changeStatus(Model $model);
	public function findById($id);
	public function destroy(Model $model);
	public function restore(Model $model, $id);
	public function delete(Model $model, $id);
}
