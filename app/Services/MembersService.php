<?php 

namespace App\Services;
use Illuminate\Support\Facades\Auth;
use App\Models\Member;
use App\Models\Organization;
use App\Models\Mortality;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
class MembersService {

    private $modelAttributes = null;
    public $model = null;
    
    public function __construct()
    {
        $this->model = new Member();
    }
    public function getMemberObj($attributes)
    {
        $attributes = json_decode( json_encode($attributes) ) ;
        $member = Member::where('emp_id', $attributes->employee_id)
        ->first()?? new Member();
        $organizations =Organization::where('id',$attributes->organization_name)->first();
        $onboard_age = (Carbon::parse($attributes->date_of_birth)->diff(Carbon::now()))->format('%y%M');
        $employeeContribution=($attributes->employee_salary*$organizations->employee_protion)/100;
        $employerContribution=($attributes->employee_salary*$organizations->employer_protion)/100;
        $contribution=($employeeContribution+$employerContribution);
        if($onboard_age<=4900){
            $sum_assured=($member->fix_salary ?? $attributes->employee_salary)*12*5;
        }else{
            $sum_assured=($member->fix_salary ?? $attributes->employee_salary)*12*3;
        };
        if($sum_assured<1500000){
            $sum_at_risk=$sum_assured;
        }
        else{
            $sum_at_risk=1500000;
        };
        $policy_fix_charge=($organizations->management_expenses)/12;
        $mortalities=Mortality::where('onboard_age',$onboard_age)->first();
        $mortality_charge=($mortalities->mortality_factor)*$sum_at_risk*.90;
        $admin_charge=($contribution*0.018)/12;
        $net_charge=$policy_fix_charge+$mortality_charge +$admin_charge ;
        //
        $organizationId = $organizations->id;
        $organization=Organization::where('id',$organizationId)->first();
        $organizationCode=$organization->code.'-';
        $attr = [
            'emp_id' => $attributes->employee_id,
            'member_id' => $organizationCode.$attributes->employee_id,
            'name' => $attributes->employee_name,
            'department' => $attributes->department,
            'designation' => $attributes->designation,
            'date_of_birth' => $attributes->date_of_birth,
            'onboard_age' =>$onboard_age,
            'sex' => $attributes->gender,
            'maritial_status' => $attributes->maritial_status,
            'salary' => $attributes->employee_salary,
            'fix_salary' =>$member->fix_salary ?? $attributes->employee_salary,
            'membership_date' => $attributes->membership_date,
            'is_active' => 1,
            'policy_fix_charge'=>$policy_fix_charge,
            'mortality_charge'=>$mortality_charge,
            'admin_charge'=>$admin_charge,
            'sum_at_risk'=>$sum_at_risk,
            'net_charge'=>$net_charge,
            'employeeContribution' => $employeeContribution,
            'employerContribution' => $employerContribution,
            'premium' => $contribution,
            'premium' => $contribution,
            'bank_name' => $attributes->employee_bank_account_name,
            'bank_branch_name' => $attributes->employee_bank_branch_name,
            'bank_branch_routing_number' => $attributes->employee_bank_branch_routing_number,
            'bank_account_number' => $attributes->employee_bank_account_number,
            'mobile' => $attributes->employee_mobile,
            'email' => $attributes->employee_email,
            'org_id' => $attributes->organization_name,
            'nid_number' => $attributes->employee_nid,
            'created_by' => Auth::user()->id,
        ];
        $this->modelAttributes = $attr;
        return $this;
    }

    public function createAndGetMember()
    {
        $this->model = $this->model->create($this->modelAttributes);
        return $this;
    }

    public function calculateAndGetEmployeePremiumFromSalary($salary)
    {
        return $salary ? (int)$salary * 0.05 : null;
    }

    public function memberUpdateAndGetModel($id, $params)
    {
        
    }
    
}


