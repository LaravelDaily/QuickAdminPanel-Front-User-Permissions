<?php

namespace App\Http\Requests;

use App\CrmNote;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class StoreCrmNoteRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('crm_note_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer'],
            'note'        => [
                'required'],
        ];
    }
}
