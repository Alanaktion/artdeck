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

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function formatSize(): string
    {
        $size = $this->attributes['file_size'];
        if ($size < 1e3) {
            return $size . ' bytes';
        }
        if ($size < 1e6) {
            return round($size / 1e3, 1) . ' KB';
        }
        if ($size < 1e9) {
            return round($size / 1e6, 1) . ' MB';
        }
        return round($size / 1e9, 1) . ' GB';
    }
}
