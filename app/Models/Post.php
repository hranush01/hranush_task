<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($post) {
            DB::table('post_translations')
                ->where('post_id', $post->id)
                ->update(['deleted_at' => now()]);
        });
    }

    public function languages()
    {
        return $this->belongsToMany(Language::class, 'posts_languages');
    }

    public function translations()
    {
        return $this->hasMany(PostTranslation::class, 'post_id');
    }

}
