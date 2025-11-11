<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Models\App\Cms\SocialNetwork;
use Illuminate\Database\Eloquent\Model;

class SocialNetworkingMedia extends BaseModel
{
	protected $fillable = [
		'name',
		'default_icon',
		'description',
		'is_active',
	];

	public function socialNetwork()
	{
		return $this->hasMany(SocialNetwork::class, 'social_networking_media_id');
	}
}
