<?php

namespace App\Http\Requests;

use App\Models\Language;
use Illuminate\Foundation\Http\FormRequest;

/**
 * @property $contents array
 * @property $image array
 */
class CreatePostRequest extends FormRequest
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
    public function rules():array
    {
        return [
            'image' => 'required|image|mimes:jpeg,png,jpg,gif',
            'contents' => 'required|array',
            'contents.*.title' => 'required|string|max:255',
            'contents.*.description' => 'required|string',
            'contents.*' => [
                'required',
                function ($attribute, $value, $fail) {

                    $languageCode = substr($attribute, strrpos($attribute, '.') + 1);

                    if (!Language::where('code', $languageCode)->exists()) {
                        $fail("The selected language code '$languageCode' does not exist in the languages table.");
                    }
                },
            ],
        ];
    }
}
