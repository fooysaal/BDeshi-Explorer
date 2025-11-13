<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CMSContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section_key',
        'title',
        'subtitle',
        'description',
        'image',
        'images',
        'button_text',
        'button_link',
        'metadata',
        'is_visible',
        'display_order',
    ];

    protected $casts = [
        'images' => 'array',
        'metadata' => 'array',
        'is_visible' => 'boolean',
    ];

    /**
     * Scope to get only visible content
     */
    public function scopeVisible($query)
    {
        return $query->where('is_visible', true);
    }

    /**
     * Scope to get content by section key
     */
    public function scopeBySection($query, $sectionKey)
    {
        return $query->where('section_key', $sectionKey);
    }

    /**
     * Get content ordered by display order
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('display_order', 'asc');
    }
}
