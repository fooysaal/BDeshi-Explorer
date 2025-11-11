<?php

namespace App\Helpers;

use Exception;
use Intervention\Image\ImageManagerStatic as Image;

class FileUploader
{

	public static function uploadSingleFile($file, $path, $name = null, $width = null, $height = null)
	{
		if (!isset($file)) {
			throw new Exception("File Not Found", 500);
		} else if (!isset($path)) {
			throw new Exception("File Path Not Declared", 500);
		} else {
			return self::uploadFile($file, $path, $name = null, $width = null, $height = null);
		}
	}

	public static function deleteSingleFile($fileName, $path)
	{
		if (!isset($fileName) || !isset($path)) {
			throw new Exception('Filename Or Path Not Define', 500);
		}

		$filePath = public_path() . '/uploads/' . $path . '/' . $fileName;
		if (file_exists($filePath)) {
			unlink($filePath);
			return true;
		} else {
			return false;
		}
	}

	private static function uploadFile($file, $path, $name = null, $width = null, $height = null)
	{
		$fileName = self::getFileName($file, $path, $name);
		$filePath = self::getFilePath($path);

		// $image = Image::make($file);

		// if (isset($width) && isset($height)) {
		// 	$image = $image->resize($width, $height);
		// }

		// $image->save($filePath . $fileName);

		$file->move($filePath, $fileName);

		return $fileName;
	}

	private static function getFilePath($path)
	{
		$filePath = public_path() . '/uploads/' . $path . '/';
		if (!file_exists($filePath)) {
			// if (!file_exists(public_path('/uploads/thumbs'))) {
			//     mkdir(public_path('/uploads/thumbs/'), 0777, true);
			// }

			mkdir(public_path('/uploads/' . $path . '/'), 0777, true);
			// mkdir(public_path('/uploads/thumbs/' . $path . '/'), true);
		}

		return $filePath;
	}

	private static function getFileName($file,  $path, $name)
	{
		// for uniqe image name
		$rand = substr(uniqid('', true), -5);
		$fileName = time() . '_' . $rand . '.' . $file->getClientOriginalExtension();
		// end for uniqe image name
		if (isset($name)) {
			$fileName = $name . '.' . $file->getClientOriginalExtension();
		}

		return $fileName;
	}
}
