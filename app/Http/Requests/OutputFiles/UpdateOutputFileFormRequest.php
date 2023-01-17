<?php

namespace App\Http\Requests\OutputFiles;

use Illuminate\Foundation\Http\FormRequest;

class UpdateOutputFileFormRequest extends FormRequest
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
            'incoming_at' => ['nullable', 'date'],
            'incoming_number' => ['nullable', 'string', 'min:1', 'max:255'],
            'incoming_author' => ['nullable', 'string', 'min:2', 'max:255'],
            'number' => ['nullable', 'string', 'min:1', 'max:255'],
            'date' => ['nullable', 'date'],
            'document_and_application_sheets' => ['nullable', 'string', 'min:1', 'max:4'],
            'file_mark' => ['nullable', 'string', 'min:2', 'max:255'],
            'short_description' => ['required', 'string', 'min:1', 'max:255'],
        ];
    }

}