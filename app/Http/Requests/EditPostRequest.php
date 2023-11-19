<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $image
 * @property $post_id
 * @property $language_code
 */
class EditPostRequest extends FormRequest
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
            'image' => 'mimes:jpeg,png,jpg,gif',
            'title' => 'required'
        ];
    }

    /**
     * @return void
     */
    protected function prepareForValidation():void
    {
        $this->merge([
            'post_id' => $this->route('postId'),
            'language_code' => $this->route('languageCode'),
        ]);
    }
}
