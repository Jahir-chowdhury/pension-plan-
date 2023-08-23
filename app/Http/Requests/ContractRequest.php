<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
Use APP\Models\Contract;
class ContractRequest extends FormRequest
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
            'organization_id' => 'required',
            'contract_tittle' => 'required|string|max:191',
            'contract_version' => 'required|unique:'.with(new Contract)->getTable(),
            'active_status' => 'required',
            'contract_file' => "required|mimes:pdf|max:10000"
        ];
    }
}
