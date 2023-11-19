<?php

namespace App\Models;

use App\Http\Requests\PostCommentRequest;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * @property $description
 * @property $post_translation_id int
 * @property $parent_id int
 */
class PostComment extends Model
{
    use HasFactory, SoftDeletes;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'post_translation_id',
        'parent_id',
        'description'
    ];

    public function parent()
    {
        return $this->belongsTo(PostComment::class, 'parent_id');
    }

    public function children()
    {
        return $this->hasMany(PostComment::class, 'parent_id');
    }

    /**
     * @param PostCommentRequest $request
     * @return void
     */
    public function setPostComment(PostCommentRequest $request):void
    {
        $this->description = $request->description;
        $this->post_translation_id = $request->post_translation_id;
        $this->parent_id = $request->parent_id;
    }
}
