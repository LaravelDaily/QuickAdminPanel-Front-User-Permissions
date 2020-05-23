<?php

namespace App\Http\Requests;

use App\CrmCustomer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCrmCustomerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('crm_customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'first_name' => [
                'required'],
            'status_id'  => [
                'required',
                'integer'],
        ];
    }
}
