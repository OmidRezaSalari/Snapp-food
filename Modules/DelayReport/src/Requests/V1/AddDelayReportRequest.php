<?php

namespace DelayReport\Requests\V1;

use DelayReport\Facades\OrderProviderFacade;
use Illuminate\Foundation\Http\FormRequest;

class AddDelayReportRequest extends FormRequest
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
            'orderId' => 'required|integer|exists:orders,id|min:1'
        ];
    }

    public function attributes()
    {
        return [
            "orderId" => "شناسه سفارش"
        ];
    }

    public function messages()
    {
        return [
            'orderId.exists' => __(
                "DelayReportService::client-error.order-access-denied"
            )
        ];
    }
}
