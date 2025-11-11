<?php

use Illuminate\Support\Str;

/**
 * Provided the displayable model name in singular (e.g. Book Category) 
 * from table name (e.g. book_categories) 
 * @param  String $tableName Name of the database table
 * @return String            Table name in singular in displayable format
 */
function wwsp_getSingularModelNameFromTableName($tableName) {
    $displayableModelName = '';

    $singularTableName = Str::singular($tableName);

    $tableNameArr = explode('_', $singularTableName);
    $modelNameStr = implode(" ", $tableNameArr);

    $displayableModelName = Str::title($modelNameStr);

    return $displayableModelName;
}


function wwsp_csvToArray($string) {
	$arr = [];
	$arr = explode(',', $string);

	// Filter array data to trim & remove empty indexes
	foreach($arr as $key=>$a) {
	    if(empty(trim($a))) unset($arr[$key]);            
	    else $arr[$key] = trim($a);
	}
	return $arr;
}

function wwsp_getRequestValue($requestValue, $defaultValue = null) {
	return (!empty($requestValue) || $requestValue === 0) ? $requestValue : $defaultValue;
}

function wwsp_setActionMessage($message, $type) {
	session()->flash('message', $message);
	session()->flash('messageType', $type);
}

function wwsp_slugToTitle($slug) {
	$slugAsTitle = Str::title($slug);
	return str_replace('-', ' ', $slugAsTitle);
}

function wwsp_stringToSlug($string) {
	return isset($string) ? Str::slug($string) : '';
}

function getUrlLastSegment() {
	return request()->segment(count(request()->segments()));
}
