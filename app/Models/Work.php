<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property int $id
 * @property string $type
 * @property string|null $title
 * @property string|null $description
 * @property string|null $sha1
 * @property string|null $file_path
 * @property int|null $file_size
 * @property int|null $width
 * @property int|null $height
 * @property string|null $uploader_ip
 * @property int|null $user_id
 * @property string|null $source_url
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property \Illuminate\Support\Carbon|null $deleted_at
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|Tag[] $tags
 */
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

    protected static function booted()
    {
        static::creating(function (Work $work) {
            if ($work->ip === null && request()->ip()) {
                $work->ip = request()->ip();
            }
            if ($work->user_id === null && auth()->check()) {
                $work->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
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
