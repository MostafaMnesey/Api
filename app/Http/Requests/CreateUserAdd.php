<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use App\helpers\SendResponse;
use Illuminate\Validation\ValidationException;


class CreateUserAdd extends FormRequest
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
            'title' => 'required',
            'phone' => 'required',
            'text' => 'required',
            'domain_id' => 'required|exists:domins,id',
            'name' => 'required|image|mimes:jpeg,png,jpg,gif,svg',


        ];
    }



    public function attributes()
    {
        return [
            'title' => 'Title',
            'text' => 'Text',
            'domain_id' => 'Domain',
            'phone' => 'Phone',
            'image' => 'Image',
            'album' => 'Album',
        ];
    }

}
