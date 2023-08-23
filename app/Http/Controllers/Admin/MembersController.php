<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Member;
use App\Models\Organization;
use App\Http\Requests\MemberRequest;
use App\Http\Requests\MemberBulkRequest;
use App\Models\Mortality;
use App\Rules\CheckEmployeeId;
use App\Services\MembersService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use function App\getHumanGenders;
use Illuminate\Database\Eloquent\Collection;
use App\Imports\MembersBulkUpload;
use App\Exports\ExportMember;
use Illuminate\Support\Arr;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;

class MembersController extends Controller
{
    public $model = null;
    public $service = null;

    public function __construct()
    {
        $this->model = new Member();
        $this->service = new MembersService();
    }

    public function index(Request $request)
    {
        $selectedOrganization = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        return view('admin.members.index', compact('organizations', 'selectedOrganization'));
    }

    public function create(Request $request)
    {
        $organizations = Organization::all();
        return view('admin.members.create_member', compact('organizations'));
    }

    public function store(MemberRequest $request)
    {
        $validated = $request->validated();
        // adding fields ( Later should be file upload and get url )
        //$request->file_employee_photo = '';
        //$request->file_employee_nid = '';

        try {
            DB::beginTransaction();
            $memberObg = $this->service->getMemberObj($request->all())
                ->createAndGetMember();
            if ($memberObg->model) {
                DB::commit();
                return back()->with('success', 'Member created successfully');
            }
        } catch (\Exception $e) {
            dd($e);
            DB::rollBack();
            return back()->with('error', $e->getMessage());
        }
    }

    public function update(Request $request)
    {
        $member = Member::where('member_id', $request->member_id)->first();
        $organization = Organization::where('id', $request->organization_id)->first();
        
        $employeeContribution=($request->employee_salary*$organization->employee_protion)/100;
        $employerContribution=($request->employee_salary*$organization->employer_protion)/100;
        $contribution=($employeeContribution+$employerContribution);
        // dd($request->employee_salary);
        // dd($contribution);
        try {
            DB::beginTransaction();

            $member->emp_id = $request->employee_id ?? $member->emp_id;
            $member->member_id = $request->member_id ?? $member->member_id;
            $member->date_of_birth = $request->date_of_birth ?? $member->date_of_birth;
            $member->fix_salary = $request->fix_salary ?? $member->fix_salary;
            $member->onboard_age = $request->onboard_age ?? $member->onboard_age;
            $member->membership_date = $request->membership_date ?? $member->membership_date;
            $member->is_active = $request->is_active ?? $member->is_active;
            $member->policy_fix_charge = $request->policy_fix_charge ?? $member->policy_fix_charge;
            $member->admin_charge = $request->admin_charge ?? $member->admin_charge;
            $member->mortality_charge = $request->mortality_charge ?? $member->mortality_charge;
            $member->sum_at_risk = $request->sum_at_risk ?? $member->sum_at_risk;
            $member->employeeContribution = $employeeContribution ?? $member->employeeContribution;
            $member->employerContribution = $employerContribution ?? $member->employerContribution;
            $member->premium = $contribution ?? $member->premium;
            $member->net_charge = $request->net_charge ?? $member->net_charge;
            $member->mobile = $request->mobile ?? $member->mobile;
            $member->email = $request->email ?? $member->email;
            $member->org_id = $request->org_id ?? $member->org_id;
            //  $member->fix_salary = $request->fix_salary ?? $member->fix_salary;
            $member->name = $request->employee_name ?? $member->name;
            $member->department = $request->department ?? $member->department;
            $member->designation = $request->designation ?? $member->designation;
            $member->sex = $request->gender ?? $member->sex;
            $member->maritial_status = $request->maritial_status ?? $member->maritial_status;
            $member->salary = $request->employee_salary ?? $member->salary;
            $member->bank_name = $request->employee_bank_account_name ?? $member->bank_name;
            $member->bank_branch_name = $request->employee_bank_branch_name ?? $member->bank_branch_name;
            $member->bank_branch_routing_number = $request->employee_bank_branch_routing_number ?? $member->bank_branch_routing_number;
            $member->bank_account_number = $request->employee_bank_account_number ?? $member->bank_account_number;
            $member->nid_number = $request->employee_nid ?? $member->nid_number;
            $member->updated_by = Auth::user()->id;

            $member->save();
            DB::commit();

            return back()->with('success', 'Member Information updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            dd($e);
            return back()->with('error', 'Something went wrong.');
        }
    }


    public function showBulkUploadForm(Request $request)
    {
        $organizations = Organization::all();
        return view('admin.members.bulk_upload_form', compact('organizations'));
    }

    public function memberBulkUploadFieldmapping(Request $request)
    {
        $organizations = Organization::all();
        $organizationId = $request->organization;
        $code=Organization::where('id',$organizationId)->first();
        if (isset($request->member_list_file)) {
            // dd('hi1');
            $excelRows = Excel::toArray(new \App\Imports\MembersBulkUpload, request()->member_list_file, \Maatwebsite\Excel\Excel::XLSX,)[0];
            //dd($excelRows->org_id);
            //dd( $excelRows[0]['org_id']);
            if ($code->code == $excelRows[0]['org_id']) {
                //dd('hi1');
                return view('admin.members.bulk_upload_form', compact('organizations', 'excelRows', 'organizationId'));
               
            } else {
                return Redirect::route('organization.members.bulkUploadForm')->with('error', 'Organization mismatch please select proper organization');
                
            }
        } else {
            return Redirect::route('organization.members.bulkUploadForm')
            ->with('error', 'No file choosen or file has duplicate value in emp_id,email,nid,phone,bank account no');
        }
    }

    public function memberBulkUpload(MemberBulkRequest $request)
    {

        // dd('hi');
        $organizationId = $request->organization_id;
        $employeeIds = $request->employee_id;
        $organization = Organization::where('id', $organizationId)->first();
        $organizationCode = $organization->code . '-';
        $employeeNames = $request->employee_names;
        $employeeDepartments = $request->departments;
        $employeeDesignations = $request->designations;
        $employeeDOBS = $request->date_of_births;
        $employeeGenders = $request->genders;
        $employeeMaritialStatuses = $request->maritial_statuses;
        $employeeSalaries = $request->salaries;
        $employeeBankNames = $request->bank_names;
        $employeebankBranchNames = $request->bank_branch_names;
        $employeeBankRoutingNumbers = $request->bank_routing_numbers;
        $employeeBankAccountNumbers = $request->bank_account_numbers;
        $employeeMobileNumbers = $request->mobiles;
        $employeeNidNumbers = $request->nid_numbers;
        //dd($employeeNidNumbers['0']);
        $employeeEmails = $request->emails;
        // END:: Receiving Requested array data

        //All Member Status Changed to Inactive
        $organizations = Organization::where('id', $request->organization_id)->first();
        $status_inactive = Member::where('org_id', $request->organization_id)->update(['is_active' => 0]);
        // updateOrCreate Member::
        foreach ($employeeIds as $index => $employeeId) {
            $member = Member::where('email', $employeeEmails[$index])->where('org_id', $request->organization_id)
                ->first() ?? new Member();
            $onboard_age = (Carbon::parse($employeeDOBS[$index])->diff(Carbon::now()))->format('%y%M');
            $employerContribution=$employeeSalaries[$index] * ($organizations->employer_protion) / 100;
            $employeeContribution= $employeeSalaries[$index] * ($organizations->employee_protion) / 100;
            $contribution = ($employerContribution +$employeeContribution);
            if ($onboard_age <= 4900) {
                $sum_assured = ($member->fix_salary ?? $employeeSalaries[$index]) * 12 * 5;
            } else {
                $sum_assured = ($member->fix_salary ?? $employeeSalaries[$index]) * 12 * 3;
            };
            if ($sum_assured < 1500000) {
                $sum_at_risk = $sum_assured;
            } else {
                $sum_at_risk = 1500000;
            };
            $policy_fix_charge = ($organizations->management_expenses) / 12;
            $mortalities = Mortality::where('onboard_age', $onboard_age)->first();
            $mortality_charge = ($mortalities->mortality_factor) * $sum_at_risk * .90;
            $admin_charge = ($contribution * 0.018) / 12;
            $net_charge = $policy_fix_charge + $mortality_charge + $admin_charge;
            $attr = [
                'emp_id' => $employeeId,
                'member_id' => $organizationCode . $employeeId,
                'name' => $employeeNames[$index],
                'department' => $employeeDepartments[$index],
                'designation' => $employeeDesignations[$index],
                'date_of_birth' => $member->date_of_birth ?? $employeeDOBS[$index],
                'onboard_age' => $onboard_age,
                'sex' => $employeeGenders[$index],
                'maritial_status' => $employeeMaritialStatuses[$index],
                'salary' => $employeeSalaries[$index],
                'membership_date' => $member->membership_date ?? Carbon::now(),
                'fix_salary' => $member->fix_salary ?? $employeeSalaries[$index],
                'policy_fix_charge' => $policy_fix_charge,
                'admin_charge' => $admin_charge,
                'mortality_charge' => $mortality_charge,
                'sum_at_risk' => $sum_at_risk,
                'net_charge' => $net_charge,
                'is_active' => 1,
                'employerContribution' => $employerContribution,
                'employeeContribution' => $employeeContribution,
                'premium' => $contribution,
                'bank_name' => $employeeBankNames[$index],
                'bank_branch_name' => $employeebankBranchNames[$index],
                'bank_branch_routing_number' => $employeeBankRoutingNumbers[$index],
                'bank_account_number' => $member->bank_account_number ?? $employeeBankAccountNumbers[$index],
                'mobile' => $employeeMobileNumbers[$index],
                'email' => $member->email ?? $employeeEmails[$index],
                'org_id' => $request->organization_id,
                'created_by' => Auth::user()->id,
                'nid_number' => $member->nid_number ?? $employeeNidNumbers[$index],
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ];
            $member->fill($attr);
            $member->save();
        }
        return Redirect::route('organization.members.bulkUploadForm')->with('success', 'Member Uploaded Sucessfully');
    }
    public function memberBulkDownload(Request $request)
    {
        $organizations = Organization::all();
        return view('admin.members.bulk_download_form', compact('organizations'));
    }

    public function memberExport($id){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {

            $allResult = Member::where('org_id', $id)->get();
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $activeSheet->SetCellValue('A1', 'Member Name');
            $activeSheet->SetCellValue('B1', 'Member Id');
            $activeSheet->SetCellValue('C1', 'Date Of Birth');
            $activeSheet->SetCellValue('D1', 'Salary');
            $activeSheet->SetCellValue('E1', 'Gender');
            $activeSheet->SetCellValue('F1', 'Premium');
            $activeSheet->SetCellValue('G1', 'Bank Name');
            $activeSheet->SetCellValue('H1', 'Bank Account No');
            $activeSheet->SetCellValue('I1', 'Phone');
            $activeSheet->SetCellValue('J1', 'Email');
            $activeSheet->SetCellValue('K1', 'NID No');
            $activeSheet->SetCellValue('L1', 'Department');
            $activeSheet->SetCellValue('M1', 'Designation');
            $activeSheet->getStyle('A1:M1')->getFont()->setBold(true);
            $rowCount = 2;
            foreach ($allResult as $key => $value) {
                $activeSheet->SetCellValue('A' . $rowCount, $value['name']);
                $activeSheet->SetCellValue('B' . $rowCount, $value['member_id']);
                $activeSheet->SetCellValue('C' . $rowCount, $value['date_of_birth']);
                $activeSheet->SetCellValue('D' . $rowCount, $value['salary']);
                $activeSheet->SetCellValue('E' . $rowCount, $value['sex']);
                $activeSheet->SetCellValue('F' . $rowCount, $value['premium']);
                $activeSheet->SetCellValue('G' . $rowCount, $value['bank_name']);
                $activeSheet->SetCellValue('H' . $rowCount, $value['bank_account_number']);
                $activeSheet->SetCellValue('I' . $rowCount, $value['mobile']);
                $activeSheet->SetCellValue('J' . $rowCount, $value['email']);
                $activeSheet->SetCellValue('K' . $rowCount, $value['nid_number']);
                $activeSheet->SetCellValue('L' . $rowCount, $value['department']);
                $activeSheet->SetCellValue('M' . $rowCount, $value['designation']);
                $rowCount++;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="members.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
 
}
