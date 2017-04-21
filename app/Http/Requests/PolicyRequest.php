<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PolicyRequest extends FormRequest
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
            'policy_no' => 'required|unique:policies',
            'duration_type' => 'required',
            'agent' => 'required',
            'effective_date' => 'required',
            'carrier' => 'required',
            'vehicle' => 'required',
            'type' => 'required'
        ];
    }
}
