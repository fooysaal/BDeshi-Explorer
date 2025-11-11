<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use Illuminate\Database\Eloquent\Model;

class PageTemplate extends BaseModel
{
    protected $fillable = ['name', 'description'];

    // Define reverse relationship (if needed)
    public function pages()
    {
        return $this->hasMany(Page::class);
    }
}
