<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Lesson extends Model
{
    protected $fillable = [
        'module_id',
        'title',
        'video_path',
        'is_preview',
        'order'
    ];

    public function module(): BelongsTo
    {
        return $this->belongsTo(Module::class);
    }
}
