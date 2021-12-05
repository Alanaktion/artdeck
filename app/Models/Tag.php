<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @property int $id
 * @property string $name
 * @property int|null $user_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read User|null $user
 * @property-read \Illuminate\Database\Eloquent\Collection|Work[] $works
 */
class Tag extends Model
{
    use HasFactory;

    protected $fillable = ['name'];

    protected static function booted()
    {
        static::creating(function (Tag $tag) {
            if ($tag->user_id === null && auth()->check()) {
                $tag->user_id = auth()->id();
            }
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function works()
    {
        return $this->belongsToMany(Work::class);
    }
}
