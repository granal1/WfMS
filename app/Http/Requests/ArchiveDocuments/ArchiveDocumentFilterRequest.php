<?php

namespace App\Http\Requests\ArchiveDocuments;

use Illuminate\Foundation\Http\FormRequest;

class ArchiveDocumentFilterRequest extends FormRequest
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
            'short_description' => '',
            'path' => '',
            'content' => '',
            'year' => '',
            'from_date' => '',
            'to_date' => '',
        ];
    }
}
