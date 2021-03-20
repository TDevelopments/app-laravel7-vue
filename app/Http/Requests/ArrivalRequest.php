<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ArrivalRequest extends FormRequest
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
        $rules = [
            'city' => ['required', 'string'],
            'arrival_date' => ['required', 'date'],
            'catalogue_id' => ['required']
        ];

        foreach($this->request->get('items') as $key => $val)
        {
            $rules['items.'.$key] = 'required|max:10';
        }

        return $rules;
    }
}
