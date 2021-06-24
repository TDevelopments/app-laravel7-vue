<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => ['required', 'string'],
            /* 'lastname' => ['required','string'], */
            'email' => ['nullable', 'email', 'unique:users,email,'.$this->user()->id],
            'password' => ['nullable', 'min:8', 'confirmed', 'string'],
            'address' => ['required','string'],
            'ruc' => ['integer','unique:users,ruc,'.$this->user()->ruc],
            'dni' => ['required', 'integer','unique:users,dni,'.$this->user()->dni],
            'phone' => ['required','integer'],
            'gender' => ['string', 'in:masculine,female,unisex,none'],
            'city' => ['required', 'string']
        ];
    }
}
