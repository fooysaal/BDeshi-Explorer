<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FaqCategory extends BaseModel
{
    use CommonEventObserver, CommonScopes, SoftDeletes;

    public function faqs()
{
    return $this->hasMany(Faq::class, 'faq_category_id');
}
}
