<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        // only allow updates if the user is logged in
        return backpack_auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users,email,' . $this->id, // Ensure email is unique
            'person' => 'required|array', // Ensure 'person' is an array
            'person.first_name' => 'required|string|max:255',
            'person.last_name' => 'required|string|max:255',
            'person.gender' => 'required|in:Male,Female', // Validate gender
            'person.street' => 'required|string|max:255',
            'person.number' => 'required|string|max:255',
            'person.city' => 'required|string|max:255',
            'person.zip' => 'required|string|max:255',
            'person.region' => 'required|string|max:255',
            'person.country' => 'required|string|max:255',
            'person.phone' => 'required|string|max:255',
            'active' => 'required|boolean', // Validate active status
            'two_factor_secret' => 'nullable|boolean', // Validate 2FA status
        ];
    }

    

    /**
     * Get the validation attributes that apply to the request.
     *
     * @return array
     */
    public function attributes()
    {
        return [
            //
        ];
    }

    /**
     * Get the validation messages that apply to the request.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'person.first_name.required' => 'The first name field is required.',
            'person.last_name.required' => 'The last name field is required.',
            'person.gender.required' => 'The gender field is required.',
            'person.street.required' => 'The street field is required.',
            'person.number.required' => 'The number field is required.',
            'person.city.required' => 'The city field is required.',
            'person.zip.required' => 'The ZIP field is required.',
            'person.region.required' => 'The region field is required.',
            'person.country.required' => 'The country field is required.',
            'person.phone.required' => 'The phone field is required.',
        ];
    }
}
