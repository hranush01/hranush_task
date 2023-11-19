<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\DB;

class PostTranslation extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'description',
        'language_id'
    ];

    protected static function booted()
    {
        parent::booted();

        static::deleting(function ($post_translation) {
            DB::table('post_comments')
                ->where('post_translation_id', $post_translation->id)
                ->update(['deleted_at' => now()]);
        });
    }

    public function post()
    {
        return $this->belongsTo(Post::class, 'post_id');
    }

    public function comments()
    {
        return $this->hasMany(PostComment::class, 'post_translation_id');
    }
}
