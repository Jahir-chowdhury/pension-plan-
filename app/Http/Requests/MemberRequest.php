<?php

namespace App\Http\Requests;
use Illuminate\Foundation\Http\FormRequest;
use App\Models\Member;
use Illuminate\Validation\Rule;
class MemberRequest extends FormRequest
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
        $table = with(new Member())->getTable();
        $rule_member_id = Rule::unique($table,'member_id');
        $rule_emp_id= Rule::unique($table,'emp_id');
        $rule_nid_number = Rule::unique($table,'nid_number');
        $rule_bank_account_number = Rule::unique($table,'bank_account_number');
        $rule_email = Rule::unique($table,'email');
        $rule_bank_account_number = Rule::unique($table,'bank_account_number');
        $rule_mobile = Rule::unique($table,'mobile');
        if ($this->method() !== 'POST') {
            $member = Member::where('member_id',$this->member_id)->first();
            $rule_member_id=Rule::unique($table, 'member_id')->ignore($member->member_id,'member_id');
            $rule_emp_id=Rule::unique($table, 'emp_id')->ignore($member->id,'id');
            $rule_nid_number=Rule::unique($table, 'nid_number')->ignore($member->id,'id');
            $rule_bank_account_number=Rule::unique($table, 'bank_account_number')->ignore($member->id,'id');
            $rule_email=Rule::unique($table, 'email')->ignore($member->id,'id');
            $rule_bank_account_number=Rule::unique($table, 'bank_account_number')->ignore($member->id,'id');
            $rule_mobile=Rule::unique($table, 'mobile')->ignore($member->id,'id');
        }
        // dd($rule_mobile);
        $rule = [
            'employee_name' => 'required|string|max:191',
            'member_id' => $rule_member_id,
            'department' => 'required|string|min:2,max:191',
            'designation' => 'required|string|min:2,max:191',
            'employee_id' =>$rule_emp_id,
            'employee_nid' =>$rule_nid_number,
            'date_of_birth' => 'required|date',
            'employee_salary' => 'required|numeric',
            'membership_date' => 'required|date',
            'employee_bank_account_name' => 'required',
            'employee_bank_branch_name' => 'required',
            'employee_bank_branch_routing_number' => 'required',
            'employee_bank_account_number' => $rule_bank_account_number,
            'employee_email' => $rule_email,
            // 'employee_nid' => 'required|unique:'.$table.',nid_number',
            'mobile' =>$rule_mobile,
        ];
        return $rule;
    }
}
