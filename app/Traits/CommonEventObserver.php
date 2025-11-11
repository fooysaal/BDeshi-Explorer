<?php

namespace App\Traits;

use Illuminate\Support\Facades\Schema;

trait CommonEventObserver
{

  public static function boot()
  {
    parent::boot();

    /*
			Eloquent models fire several events, allowing you to hook into the following points in a model's lifecycle:
			retrieved, creating, created, updating, updated, saving, saved, deleting,  deleted, restoring, restored.

			Events allow you to easily execute code each time a specific model class is saved or updated in the database.
		 */

    /* * During a model create Eloquent will also update the updated_at field so
		 * need to have the updated_by field here as well * */
    static::creating(function ($model) {
      if (Schema::hasColumn($model->getTable(), 'order')) {
        $model->order = !is_null($model->order) ? $model->order : 0;
      }

      if (Schema::hasColumn($model->getTable(), 'is_active')) {
        $model->is_active = !is_null($model->is_active) ? $model->is_active : 0;
      }

      if (Schema::hasColumn($model->getTable(), 'created_by')) {
        $model->created_by = (request()->user()) ? request()->user()->id : null;
      }
      if (Schema::hasColumn($model->getTable(), 'updated_by')) {
        $model->updated_by = (request()->user()) ? request()->user()->id : null;
      }
    });

    static::created(function ($model) {
			session()->flash('message', wwsp_getSingularModelNameFromTableName($model->getTable()) . ' Saved Successfully!');
      session()->flash('messageType', 'success');
    });

    static::updating(function ($model) {
      if (Schema::hasColumn($model->getTable(), 'order')) {
        $model->order = !is_null($model->order) ? $model->order : 0;
      }

      if (Schema::hasColumn($model->getTable(), 'is_active')) {
        $model->is_active = !is_null($model->is_active) ? $model->is_active : 0;
      }
      if (Schema::hasColumn($model->getTable(), 'updated_by')) {
        $model->updated_by = request()->user()->id;
      }
    });
    static::updated(function ($model) {
			session()->flash('message', wwsp_getSingularModelNameFromTableName($model->getTable()) . ' Updated Successfully!');
      session()->flash('messageType', 'info');
    });

    /*
			 * Deleting a model is slightly different than creating or deleting. For
			 * deletes we need to save the model first with the deleted_by field
		*/
    static::deleting(function ($model) {
      if (Schema::hasColumn($model->getTable(), 'deleted_by')) {
        $model->deleted_by = request()->user()->id;
        $model->save();
      }
    });
    static::deleted(function ($model) {
			session()->flash('message', wwsp_getSingularModelNameFromTableName($model->getTable()) . ' Deleted Successfully!');
      session()->flash('messageType', 'danger');
    });

    static::restored(function ($model) {
			session()->flash('message', wwsp_getSingularModelNameFromTableName($model->getTable()) . ' Restored Successfully!');
			session()->flash('messageType', 'success');
		});
  }
}
