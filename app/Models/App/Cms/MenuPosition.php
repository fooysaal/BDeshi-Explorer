<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonScopes;
use App\Models\App\Cms\Menu;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class MenuPosition extends BaseModel
{
    use CommonScopes , SoftDeletes;

	protected $fillable = [
		'name',
		'alias',
		'code',
		'description',
		'is_active',
		'is_default',
	];

	public function menu()
	{
		return $this->hasMany(Menu::class, 'menu_position_id');
	}
}
