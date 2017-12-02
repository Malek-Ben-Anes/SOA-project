<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Carbon\Carbon;

class ProjectRequest extends FormRequest {

    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize() {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules() {
        return [
            'title' => 'required',
            'description' => 'required',
            'budget' => 'required',
            // 'starting_date' => 'required', min:' . Carbon::yesterday() .'|
            // dd()
            'Ending_Date' => 'required|date_format:Y-m-d|max:' . Carbon::now()->addDays(15),
            'enterprise_id' => 'required',
                // 'deadline' => 'date_format:Y-m-d H:i:s'
        ];
    }

}
