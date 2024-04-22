<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CreateOrderRequest extends FormRequest
{
    /**
     * Indicates if the validator should stop on the first rule failure.
     *
     * @var bool
     */
    protected $stopOnFirstFailure = true;

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
            'order' => 'required|array',
            'order.*.count' => 'required|integer',
            'amount' => 'required|integer',
            'delivery' => 'required|integer|min:0|max:400',
            'userInfo' => 'required|array',
            'userInfo.firstName' => 'required|string',
            'userInfo.secondName' => 'nullable|string',
            'userInfo.address' => 'required|string',
            'userInfo.phone' => 'required|min:16|max:16',
            'userInfo.comment' => 'nullable|string|max:255',
            'userInfo.email' => 'nullable|email:rfc,dns',
            'online' => 'required|bool',
            'typeOfDelivery' => 'required|min:1|max:2',
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'order.required' => 'Поле order обязательное',
            'amount.required' => 'Поле amount обязательное',
            'delivery.required' => 'Поле delivery обязательное',
            'online.required' => 'Поле online обязательное',
            'typeOfDelivery.required' => 'Поле typeOfDelivery обязательное',
            'userInfo.required' => 'Поле userInfo обязательное',
        ];
    }
}
