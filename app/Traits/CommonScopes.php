<?php

namespace App\Traits;

trait CommonScopes
{
	public function scopeActive($query)
	{
		return $query->where('is_active', 1);
	}

	public function scopeInActive($query)
	{
		return $query->where('is_active', 0);
	}

	public function scopeDescending($query, $field = null)
	{
		if ($field) {
			return $query->orderBy($field, 'desc');
		}
		return $query->orderBy('created_at', 'desc');
	}

	public function scopeAscending($query, $field = null)
	{
		if ($field) {
			return $query->orderBy($field, 'asc');
		}
		return $query->orderBy('created_at', 'asc');
	}

	public function scopePublic($query)
	{
		return $query->where('is_public', 1);
	}
}
