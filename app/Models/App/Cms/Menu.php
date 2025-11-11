<?php

namespace App\Models\App\Cms;

use App\Models\BaseModel;
use App\Traits\CommonEventObserver;
use App\Traits\CommonScopes;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

class Menu extends BaseModel
{
  use CommonScopes , SoftDeletes;

  
  // public function children()
  //   {
  //       return $this->hasMany(Menu::class, 'parent_id')
  //           ->orderBy('display_order', 'asc');
  //   }

  //   public function activeChildren()
  //   {
  //       return $this->children()->active(); // Only fetch active child menus
  //   }

  //   public function menuPosition()
  //   {
  //       return $this->belongsTo(MenuPosition::class, 'menu_position_id');
  //   }

  //   public function scopeActive($query)
  //   {
  //       return $query->where('is_active', 1);
  //   }

  public function children()
  {
    return $this->hasMany('App\Models\App\Cms\Menu', 'parent_id')->orderBy('display_order', 'asc')->active();
  }
  public function parent()
  {
      return $this->belongsTo(Menu::class, 'parent_id');
  }


  public function menuPosition()
  {
    return $this->belongsTo('App\Models\App\Cms\MenuPosition', 'menu_position_id');
  }

  public function page()
  {
    return $this->belongsTo('App\Models\App\Cms\Page', 'page_id');
  }

  public function getPositionNameAttribute()
  {
    // dd($this->faqCategory);
    return optional($this->menuPosition)->name;
  }

  public function getPageTitleAttribute()
  {
    // dd($this->faqCategory);
    return optional($this->page)->title;
  }

  // mutator
  public function setDisplayOrderAttribute($value)
  {
    if (isset($value)) {
      $this->attributes['display_order'] = $value;
    } else {

      $this->attributes['display_order'] = 0;
    }
  }
}
