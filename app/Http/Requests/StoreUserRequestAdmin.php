<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequestAdmin extends FormRequest
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
            'email' => ['required', 'email', 'unique:users,email'],
            'password' => ['required', 'min:8', 'confirmed', 'max:255','string'],
            'address' => ['string'],
            'ruc' => ['integer' ,'unique:users,ruc'],
            'dni' => ['required', 'integer', 'unique:users,dni'],
            'phone' => ['required','integer'],
            'gender' => ['string', 'in:masculine,female'],
            'city' => ['string'],
            'roles' => ['required', 'array'],
            'roles.*' => ['required', 'string'],
        ];
    }
}
