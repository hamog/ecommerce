<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize(): bool
    {
        return $this->user()->can('create products');
    }

    /**
     * Prepare input for validation
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        $this->merge([
            'track_quantity' =>
                $this->has('track_quantity') &&
                $this->input('track_quantity') == 'on',
            'sell_out_of_stock' =>
                $this->has('sell_out_of_stock') &&
                $this->input('sell_out_of_stock') == 'on',
        ]);
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'sku' => 'nullable|string|unique:products,sku',
            'track_quantity' => 'nullable|boolean',
            'quantity' => 'required_if:track_quantity,true|nullable|int',
            'sell_out_of_stock' => 'required_if:track_quantity,true|boolean',
            'category_id' => 'required|int|exists:categories,id',
            'price' => 'required|numeric',
            'cost' => 'nullable|numeric',
            'discounted_price' => 'nullable|numeric',
            'status' => 'required|string|in:active,draft,review',
            'images' => 'nullable|array',
            'images.*' => 'string',
        ];
    }
}
