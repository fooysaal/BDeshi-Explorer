<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use Illuminate\Database\Eloquent\SoftDeletes;

class EmailSubscriber extends BaseModel
{
    use CommonEventObserver;
    use SoftDeletes;

    protected $table = 'email_subscribers';
}
