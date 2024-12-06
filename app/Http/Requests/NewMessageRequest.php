<?php

namespace App\Http\Requests;

use App\helpers\SendResponse;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\ValidationException;

class NewMessageRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }
    protected function failedValidation(Validator $validator)
    {
        if ($this->is('api/*')) {
            $response = SendResponse::sendResponse(422, 'validation error', $validator->messages()->all());
            throw new ValidationException($validator, $response);
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'email' => 'required|email',
            'message' => 'required',
            'phone' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'name is required',
            'email.required' => 'email is required',
            'email.email' => 'email is not valid',
            'message.required' => 'message is required',
            'phone.required' => 'phone is required',
        ];
    }
    public function attributes()
    {
        return [
            'name' => 'name',
            'email' => 'email',
            'message' => 'message',
            'phone' => 'phone',
        ];
    }

}
