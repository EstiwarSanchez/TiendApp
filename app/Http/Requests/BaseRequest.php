<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\ValidationException;

class BaseRequest extends FormRequest
{
   /**
     * Return validation errors json
     * @param  \Illuminate\Validation\Validator $validator
     * @return \Illuminate\Http\Exceptions\HttpResponseException
     */
    protected function failedValidation(Validator $validator)
    {
        $errors = (new ValidationException($validator))->errors();
        throw new HttpResponseException(
            response()->json([
                'status' => 0,
                'message' => __('Validation error'),
                'errors' => $errors
            ], 422)
        );
    }
}
