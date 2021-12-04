<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Work extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'source_url',
    ];

    public function getFileUrlAttribute(): ?string
    {
        if (!$this->attributes['file_path']) {
            return null;
        }
        return '/storage/' . $this->attributes['file_path'];
    }

    public function getThumbnailUrlAttribute(): ?string
    {
        if ($this->attributes['type'] !== 'image') {
            return null;
        }
        return '/storage/works/thumbnail/' . $this->attributes['sha1'] . '.jpg';
    }
}
