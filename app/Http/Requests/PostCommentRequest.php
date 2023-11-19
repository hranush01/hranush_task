<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $post_translation_id int
 * @property $parent_id int
 * @property $description string
 */
class PostCommentRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'description' => 'required|min:3',
            'post_translation_id' => 'required|exists:post_translations,id',
            'parent_id' => 'exists:post_comments,id',
        ];
    }
}
