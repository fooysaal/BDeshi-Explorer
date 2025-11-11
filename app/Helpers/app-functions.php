<?php

use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

// use Auth;

// use Exception;

function updateModelAttributes($model, $fields, $request)
{
    foreach ($fields as $field) {
        if ($request->filled($field)) {
            $model->{$field} = $request->{$field};
        }
    }

    if($request->has('title')) {
		$model->slug = Str::slug($request->title);
	}

    return $model;
}


/**
 * check file exist or not
 *
 * @param string $fileName
 * @param string $path
 * @return bool
 */
function fileExist($fileName, $path)
{
	return file_exists(public_path() . "/uploads/$path/$fileName");
}

/**
 * delete file form serve
 *
 * @param string $fileName
 * @param string $path
 * @return bool
 */
function deleteFile($fileName, $path)
{
	if ($fileName) {
		return unlink(public_path() . "/uploads/$path/$fileName");
	}
}

/**
 * delete file if exist on server
 *
 * @param string $fileName
 * @param string $path
 * @return bool
 */
function fileExistAndDelete($fileName, $path)
{
	if (fileExist($fileName, $path)) {
		return deleteFile($fileName, $path);
	} else {
		return false;
	}
}

function str_slug(string $value)
{
	if ($value) {
		return Illuminate\Support\Str::slug($value);
	} else {
		throw new Exception("slug parameter required");
	}
}

/**
 * validation message
 *
 * @param  $errors
 * @return void
 */
function validationError($errors)
{
	// dd($errors);
	echo implode(" ", $errors);
}

function toNumber($number, $digit = null)
{
	return number_format($number, $digit ?? 2);
}

function toLocalDate($date, $formate = null)
{
	if ($formate) {
		return date($formate, strtotime($date));
	}
	return date("d-m-Y", strtotime($date));
}

function getDashboardRouteBasedOnUserType() {
	$dashboardRoute = '';
	if(Auth::check()) {

		if(\Auth::user()->isDeveloper())
			$dashboardRoute = route('developer.dashboard');

		elseif(\Auth::user()->isAdmin())
			$dashboardRoute = route('admin.dashboard');

		elseif(\Auth::user()->isCustomer())
			$dashboardRoute = route('customer.dashboard');

	}

	return $dashboardRoute;

}

function isDeleteAble($key = '')
{
    if (is_null($key)) {
        return false;
    }

    return config("application-control." . $key);
}
