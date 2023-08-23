<?php
namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Organization;
use Illuminate\Validation\Rule;
class OrganizationRequest extends FormRequest
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
        $table = with(new Organization())->getTable();
        $rule_code = Rule::unique($table,'code');
        $rule_name = Rule::unique($table,'name');
        $rule_phone = Rule::unique($table,'phone');
        $rule_email = Rule::unique($table,'email');
        $rule_bank_account_number = Rule::unique($table,'bank_account_number');
        if ($this->method() !== 'POST') {
            $organization = Organization::where('code',$this->code)->first();
            $rule_code=Rule::unique($table, 'code')->ignore($organization->code,'code');
            $rule_name=Rule::unique($table, 'name')->ignore($organization->id,'id');
            $rule_phone=Rule::unique($table, 'phone')->ignore($organization->id,'id');
            $rule_email=Rule::unique($table, 'email')->ignore($organization->id,'id');
            $rule_bank_account_number=Rule::unique($table, 'bank_account_number')->ignore($organization->id,'id');

        }
        return [
            'code'=>$rule_code,
            'name' =>$rule_name,
            //'mother_organization_id' => 'nullable|numeric',
            // 'payable_to' => 'required|numeric|nullable',
            //'phone' => 'required|unique:'.$table.',phone,'.$organization->id,'id',
            'address' => 'required',
            'email' =>$rule_email,
             'phone' =>$rule_phone,
            'contract_date' => 'required',
            'commencement_date' => 'required',
            'profit_commision' => 'required',
            'management_expenses' => 'required',
            'sold_by' => 'nullable',
            'sold_as' => 'nullable',
            'marketed_by' => 'nullable',
            'bank_name' => 'required',
            'bank_branch_name' => 'required',
            'bank_account_number' =>$rule_bank_account_number,
            'bank_account_name' => 'required',
        ];
    }
}
