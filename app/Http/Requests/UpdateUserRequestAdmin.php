<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequestAdmin extends FormRequest
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
            'lastname' => ['string'],
            'email' => ['nullable', 'email', 'unique:users,email,'.$this->user->id],
            'password' => ['nullable', 'min:8', 'confirmed', 'string'],
            'address' => ['string'],
            'ruc' => ['integer','unique:users,ruc,'.$this->user->id],
            'dni' => ['required', 'integer', 'unique:users,dni,'.$this->user->id],
            'phone' => ['required','integer'],
            'gender' => ['string', 'in:masculine,female'],
            'city' => ['string'],
            'roles' => ['array'],
            'roles.*' => ['required', 'string']
        ];
    }
}
