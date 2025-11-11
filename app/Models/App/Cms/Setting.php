<?php

namespace App\Models\App\Cms;

use App\Models\User;
use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends BaseModel
{
    use CommonScopes, HasFactory;

    protected $table = 'settings';

	protected $fillable = [
		'title',
		'value',
		'description',
		'created_by',
		'updated_by',
	];

	public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function createdBy()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    public function updatedBy()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
