<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserDetailRequest extends FormRequest
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
            'first_name' => 'required',
            'last_name' => 'required',
        ];

        if ($this->request->has('password')) {
            if ($this->request->get('password') != null) {
                $rules['password'] = 'required|confirmed';
            }
        }

        return $rules;
    }

    public function response(array $errors)
    {
        return response()->json([
            'status' => 'error',
            'errors' => $errors
        ]);
    }
}
