<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ServerRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'model' => 'required|string|max:100',
            'ram_size' => 'required|integer|min:1',
            'ram_unit' => 'required|in:GB,TB,PT',
            'ram_type' => 'required|string|max:10',
            'storage_size' => 'required|integer|min:1',
            'storage_unit' => 'required|in:GB,TB,PT',
            'storage_number' => 'required|integer|min:1',
            'storage_type_id' => 'required|exists:storage_types,id',
            'location_id' => 'required|exists:locations,id',
            'price' => 'required|numeric',
            'currency' => 'required|in:eur,usd',
        ];
    }
}
