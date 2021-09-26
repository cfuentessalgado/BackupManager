<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateServerFolderRequest extends FormRequest
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
            'path' => 'required',
            'ignore_patterns' => 'nullable|array',
            'backup_patterns' => 'nullable|array',
            'schedule' => 'required|exists:App\Models\Schedule,label',
            'hour' => 'nullable|required_if:schedule,dailyAt',
            'max_backups' => 'nullable|numeric|min:1|max:10',
        ];
    }
}
