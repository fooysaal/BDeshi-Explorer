<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class GalleryImage extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;
    protected $table = 'galleryimages';
    protected $guarded = [];
}
