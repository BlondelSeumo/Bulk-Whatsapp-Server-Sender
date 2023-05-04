<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BlogRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'title' => ['required', 'string', 'max:150'],            
            'preview' => ['image','max:1024'],
            'meta_image' => ['image','max:1024'],
            'short_description' => ['required', 'max:500'],
            'main_description' => ['required', 'max:5000'],
            'meta_title' =>  ['required', 'max:200'],
            'meta_description' =>  ['max:1000'],
            'meta_tags' =>  ['max:200'],
        ];
    }
}