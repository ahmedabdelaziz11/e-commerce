<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Http\Traits\Api\ApiResponseTrait;
use Symfony\Component\HttpFoundation\Response;

class ProductRequest extends FormRequest
{
    use ApiResponseTrait;
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'required|max:255',
            'description' => 'required|string|between:5,600',
            'price' => 'required|numeric|between:0,99999999.99',
            'is_included_vat' => 'boolean',
            'store_id' => 'required|exists:stores,id',
        ];
    }

    protected function failedValidation(\Illuminate\Contracts\Validation\Validator $validator)
    {
        $response = $this->apiResponse($validator->errors(),'validation error',Response::HTTP_BAD_REQUEST);
        throw new \Illuminate\Validation\ValidationException($validator, $response);
    }
}
