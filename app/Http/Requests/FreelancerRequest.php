<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class FreelancerRequest extends FormRequest
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
            // 'username' => 'required',
            'first_name' => 'required',
            'last_name' => 'required',
            // 'country' => 'required',
            // 'city' => 'required',
            // 'address' => 'required',
            // 'postal_code' => 'required',
            // 'image' => 'required', 
            // 'curriculum_vitae' => 'required'
        ];
    }
}
