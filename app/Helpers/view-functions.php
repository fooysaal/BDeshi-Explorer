<?php

function generateOptions($dataCollection, $indexField, $valueField, $selectedIndexValues = '', $firstOption = '') {

	$selectedValueArray = [];

	$selectedValueArray = explode(",", $selectedIndexValues);

	$options = $firstOption;
	if (count($dataCollection)) {
		foreach ($dataCollection as $dataObject) {
			if (in_array($dataObject->$indexField, $selectedValueArray)) {
				$options .= '<option value="' . $dataObject->$indexField . '" selected>' . $dataObject->$valueField . '</option>';
			} else {
				$options .= '<option value="' . $dataObject->$indexField . '">' . $dataObject->$valueField . '</option>';
			}

		}
	}

	echo $options;
}

function generateStatusOptions($dataCollection, $indexField, $valueField, $selectedIndexValues = '', $firstOption = '') {
    // Parse selected values into an array
    $selectedValueArray = explode(",", $selectedIndexValues);
    
    // Find the highest selected index to exclude previous options
    $maxSelectedIndex = max($selectedValueArray);

    $options = $firstOption;
    if (count($dataCollection)) {
        foreach ($dataCollection as $dataObject) {
            // Only include options greater than the highest selected index
            if ($dataObject->$indexField > $maxSelectedIndex) {
                $options .= '<option value="' . $dataObject->$indexField . '">' . $dataObject->$valueField . '</option>';
            }
        }
    }

    echo $options;
}


/**
 * This function is used by application menu to determine if the menu item should be marked as 'active' or not
 * @param String $routeName Name of the Route
 */
function _getCurrentRouteName() {
	return request()->route()->getName();
}

function setThisMenuActive($routeNameArr) {
	$foundActive = 0;
	foreach ($routeNameArr as $routeName) {
		if (_getCurrentRouteName() === $routeName) {
			echo 'active';
			$foundActive = 1;
		} else {
			echo '';
		}

		if ($foundActive === 1) {
			break;
		}

	}
}

function setThisMenuGroupActive($routeNameArr) {
	$foundActive = 0;
	foreach ($routeNameArr as $routeName) {
		if (_getCurrentRouteName() === $routeName) {
			echo 'active';
			$foundActive = 1;
		} else {
			echo '';
		}

		if ($foundActive === 1) {
			break;
		}

	}
}

function paginationSlCalculator($paginateRecords) {
	return ($paginateRecords->currentpage() - 1) * $paginateRecords->perpage() + 1;
}

function paginationFooter($paginateRecords, $start) {
	echo '<div class="row" style="width: 100%;">
           <div class="col-sm-8">
             ' . $paginateRecords->links() . '
           </div>
           <div class="col-sm-4 text-right" style="padding-top: 20px;">
             Showing ' . $start . ' to ' . ($start + $paginateRecords->count() - 1) . ' of  <strong>' . $paginateRecords->total() . ' entries</strong>
           </div>
        </div>';
}


function isCustomer()
{
    return auth()->check() && auth()->user()->userType->name == 'Customer';
}

function getPostsByCategories($categories = []) {
    $returnFields = ['id', 'slug', 'featured_image', 'title', 'contents', 'excerpt', 'created_at'];

    if(count($categories) > 0) {
        $categories = App\Models\App\Cms\PostCategory::whereIn('name', $categories)->get('id');
        
        if($categories) {
            $categoryIds = [];
            foreach($categories as $category) {
                $categoryIds[] = $category->id;
            }

            if(count($categoryIds) > 0) {
                return App\Models\App\Cms\Post::where('is_active',1)
                        ->whereIn('post_category_id', $categoryIds)
                        //->where()
                        ->orderBy('updated_at', 'DESC')
                        ->select($returnFields)
                        ->paginate(10);
            }
        }
        
    } else {
        return App\Models\App\Cms\Post::where('is_active',1)
                //->where()
                ->orderBy('updated_at', 'DESC')
                ->select($returnFields)
                ->paginate(10);
    }
}

// function getDataBySlug($model, $slug, $column = null)
// {
//     $modelPaths = [
//         "App\\Models\\App\\Cms\\$model",
//         "App\\Models\\App\\Inventory\\$model",
// 		"App\\Models\\Site\\Member\\$model",
// 		"App\\Models\\Site\\$model",
//     ];

//     $data = null;
//     $modelClass = null; // Initialize $modelClass to be used later

//     foreach ($modelPaths as $modelPath) {
//         if (class_exists($modelPath)) {
//             $modelClass = $modelPath;
//             $data = $modelClass::where('slug', $slug)->active();
//             break;
//         }
//     }

//     if ($data === null) {
//         // Handle the case where none of the classes exist
//         throw new \Exception("Model class not found in any specified paths.");
//     }

//     // If $column is provided, process it
//     if ($column) {
//         $column1 = explode(',', $column);
//         $column2 = array_map('trim', $column1);

//         // Get the table columns from the model
//         $tableColumns = \Illuminate\Support\Facades\Schema::getColumnListing((new $modelClass)->getTable());

//         // Filter out any invalid columns
//         $validColumns = array_intersect($column2, $tableColumns);

//         // If there are valid columns, select them
//         if (!empty($validColumns)) {
//             return $data->first($validColumns);
//         } else {
//             // No valid columns provided, return all columns
//             return $data->first();
//         }
//     } else {
//         // No columns specified, return all columns
//         return $data->first();
//     }
// }
function getDataBySlug($model, $slug, $column = null)
{
    $modelPaths = [
        "App\\Models\\App\\Cms\\$model",
        "App\\Models\\App\\Inventory\\$model",
        "App\\Models\\Site\\Member\\$model",
        "App\\Models\\Site\\$model",
    ];

    $data = null;
    $modelClass = null; // Initialize $modelClass to be used later

    foreach ($modelPaths as $modelPath) {
        if (class_exists($modelPath)) {
            $modelClass = $modelPath;
            $data = $modelClass::where('slug', $slug)->active();
            break;
        }
    }

    if ($data === null) {
        throw new \Exception("Model class not found in any specified paths.");
    }

    // ✅ Ensure `$column` is always treated as an array
    if ($column) {
        $columnArray = is_array($column) ? $column : explode(',', $column); // Convert to array if needed
        $columnArray = array_map('trim', $columnArray);

        // Get valid table columns
        $tableColumns = \Illuminate\Support\Facades\Schema::getColumnListing((new $modelClass)->getTable());
        $validColumns = array_intersect($columnArray, $tableColumns);

        return $data->first($validColumns ?: ['*']); // Return all if no valid columns
    }

    return $data->first();
}


