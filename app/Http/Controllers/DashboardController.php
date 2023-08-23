<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Organization;
use App\Models\Member;
use App\Models\Collection;
use App\Models\MemberCollectionHistory;
use App\Models\Claim;
use App\Models\ClaimPayment;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\IOFactory;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $active_org=Organization::where('is_active',true)->count();
        $inactive_org=Organization::where('is_active',false)->count();
        $active_member=Member::where('is_active',true)->count();
        $total_premium=Collection::where('status',true)->sum('amount');
        $suspense=Collection::where('status',true)->sum('suspence_amount');
        $organizations=Organization::where('is_active',true)->orderBy('created_at', 'desc')->take(5)->get();
        //
        $under_process=Claim::where('claim_status','1')->count();
        $document_required=Claim::where('claim_status','3')->count();
        $regreted=Claim::where('claim_status','5')->count();
        $settled=Claim::where('claim_status','6')->count();
        $total_claim=Claim::count();
        $claims=Claim::orderBy('created_at', 'desc')->take(5)->get();
       //dd($total_claim);
       //
        $query=Claim::where('release_for_account',1)->where('payment_done',false);
        $query1=clone $query;
        $pendingDeathPayment=$query->where('claim_type','Death')->get();
        $pendingPlanAPayment=$query1->where('claim_type','Withdrawal with plan A')->get();
        $countDeathPayment=count($pendingDeathPayment);
        $countPlanAPayment=count($pendingPlanAPayment);
        $totalPendingCount=$countDeathPayment+$countPlanAPayment;
        $providePlanAPayment=Claim::where('release_for_account',1)->where('payment_done',true)->where('claim_type','Withdrawal with plan A')->get();
        $provideDeathPayment=Claim::where('release_for_account',1)->where('payment_done',true)->where('claim_type','Death')->get();
        $countSubmitDeathPayment=count($provideDeathPayment);
        $countSubmitPlanAPayment=count($providePlanAPayment);
        $totalSubmitCount=$countSubmitDeathPayment+$countSubmitPlanAPayment;
        $dueEftReturn=Claim::where('release_for_account',True)->where('payment_done',false)->where('eft_return_updated',true)->get();
        $dueEftReturnCount=count($dueEftReturn);
        $underProcessEft= ClaimPayment::where('return_eft',true)->get();
        $underProcessEftReturnCount=count($underProcessEft);
        $totalEftReturn=Claim::where('release_for_account',True)->where('payment_done',true)->where('eft_return_updated',true)->get();
        $totalEftReturnCount=count($totalEftReturn);
        // dd($underProcessEft);

        return view('dashboard', compact('active_org','active_member','inactive_org','total_premium','organizations','suspense'
        ,'under_process','document_required','regreted','settled','total_claim','claims','countDeathPayment','countPlanAPayment'
        ,'countDeathPayment','countPlanAPayment','countSubmitPlanAPayment','countSubmitDeathPayment','totalPendingCount','totalSubmitCount',
        'dueEftReturnCount','underProcessEftReturnCount','totalEftReturnCount'
    ));
    }

    public function search(Request $request)
    {
        $selectedOrganization = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        $data['request'] = $request->all();
        // dd($data['request'] );
        $query = MemberCollectionHistory::query();
        if ($request->startDate && $request->endDate) {
            $array = [
                date('Y-m-d', strtotime($request->startDate)),
                date('Y-m-d', strtotime($request->endDate))
            ];
            $query = $query->whereBetween('created_at', $array);
        }
        // if ($request->hasAny(["organization_id", "memberCode", "reportType",  "startDate", "endDate"]))
        
            if ($request->memberCode != "") {
            $query->where('member_code',$request->memberCode);
            $installment=$query->get();
            $total_premium=$query->sum('amount');
            $total_accumulated_fund=$query->latest()->first()->accumulated_fund??0;
            $total_interest=$query->sum('interest');
            $total_net_charge=$query->sum('net_charge');
            // $total_withdrawal=$total_withdrawal??ClaimPayment::where('org_id',1)->sum('paid_amount');
            $total_withdrawal=ClaimPayment::where('member_id',$request->memberCode)->sum('paid_amount');
            // dd($total_withdrawal);

            }
            
            elseif($request->organization_id !=''){
                $query->where('org_id',$selectedOrganization->code);
                $installment=$query->get();
                $total_premium=$query->sum('amount');
                $total_interest=$query->sum('interest');
                $total_net_charge=$query->sum('net_charge');
                $total_withdrawal=ClaimPayment::where('org_id',$selectedOrganization->id)->sum('paid_amount');
                $total_accumulated_fund=$accumulated_fund??array_sum(array_column($query->select('member_code', DB::raw('MAX(created_at) as latest_date'),DB::raw('MAX(accumulated_fund) as fund'))
                ->groupBy('member_code')
                ->orderBy('latest_date')
                ->get()->toArray(),'fund'));
                // dd($total_premium);
            }
            else{
                // dd('hi');
                // dd($query->get());
                $installment=MemberCollectionHistory::get();
                $total_premium=$query->sum('amount');
                $total_interest=$query->sum('interest');
                $total_net_charge=$query->sum('net_charge');
                $total_withdrawal=$total_withdrawal??ClaimPayment::sum('paid_amount');
                $total_accumulated_fund=$accumulated_fund??array_sum(array_column($query->select('member_code', DB::raw('MAX(created_at) as latest_date'),DB::raw('MAX(accumulated_fund) as fund'))
                ->groupBy('member_code')
                ->orderBy('latest_date')
                ->get()->toArray(),'fund'));
            }
        if($total_withdrawal>$total_interest){
            $without_interest_withdrawl=($total_withdrawal-$total_interest);
        }
        else{
            $without_interest_withdrawl=0;
        }
        if($request->interestType==0){
            $total_net_balance=$total_accumulated_fund-$total_withdrawal;
        }else{
            // $total_net_balance=$total_premium-($without_interest_withdrawl+$total_net_charge);
            $total_net_balance=$total_accumulated_fund-($total_withdrawal+$total_interest);
            $total_accumulated_fund=$total_accumulated_fund-$total_interest;
            $total_withdrawal=($total_withdrawal-$total_interest)>0? ($total_withdrawal-$total_interest):0;
        }
        // dd($total_withdrawal);
        $reportType=$request->reportType;
        return view('admin.report.search',compact('organizations', 'selectedOrganization','reportType','total_premium','total_interest','total_net_charge','total_withdrawal','total_accumulated_fund','total_net_balance','installment'));
    }
    public function downloadOrg ($id){
        $allResult=MemberCollectionHistory::where('org_id', $id)->orderBy('member_code','asc')->orderBy('accumulated_fund','desc')->get();
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {

            // $allResult = MemberCollectionHistory::where('org_id', $id)->get();
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $activeSheet->SetCellValue('A1', 'Organization Code');
            $activeSheet->SetCellValue('B1', 'Member Code');
            $activeSheet->SetCellValue('C1', 'Year');
            $activeSheet->SetCellValue('D1', 'Month');
            $activeSheet->SetCellValue('E1', 'Employee Contribution');
            $activeSheet->SetCellValue('F1', 'Employer Contribution');
            $activeSheet->SetCellValue('G1', 'Premium');
            $activeSheet->SetCellValue('H1', 'Accumulated Fund');
            $activeSheet->SetCellValue('I1', 'Charge');
            $activeSheet->SetCellValue('J1', 'Interest');
            $activeSheet->SetCellValue('K1', 'Organization Installment No');
            $activeSheet->SetCellValue('L1', 'Individual Installment No');
            $activeSheet->SetCellValue('L1', 'Individual Installment No');
            $activeSheet->SetCellValue('M1', 'Total Individual Fund');
            $activeSheet->getStyle('A1:M1')->getFont()->setBold(true);
            $rowCount = 2;
            $pre_fund=null;
            foreach ($allResult as $key => $value) {
                $net_fund =MemberCollectionHistory::where('member_code',$value->member_code)->latest()->first();
                if($net_fund->accumulated_fund==$pre_fund){
                    $total_fund=null;
                }
                else{
                    $total_fund=$net_fund->accumulated_fund;
                }
                $org_installment_no=$value->organizationCollection->installment_no;
                $activeSheet->SetCellValue('A' . $rowCount, $value['org_id']);
                $activeSheet->SetCellValue('B' . $rowCount, $value['member_code']);
                $activeSheet->SetCellValue('C' . $rowCount, $value['year']);
                $activeSheet->SetCellValue('D' . $rowCount, $value['month']);
                $activeSheet->SetCellValue('E' . $rowCount, $value['employeeContribution']);
                $activeSheet->SetCellValue('F' . $rowCount, $value['employerContribution']);
                $activeSheet->SetCellValue('G' . $rowCount, $value['amount']);
                $activeSheet->SetCellValue('H' . $rowCount, $value['accumulated_fund']);
                $activeSheet->SetCellValue('I' . $rowCount, $value['net_charge']);
                $activeSheet->SetCellValue('J' . $rowCount, $value['interest']);
                $activeSheet->SetCellValue('K' . $rowCount, $org_installment_no);
                $activeSheet->SetCellValue('L' . $rowCount,  $value['installment_no']);
                $activeSheet->SetCellValue('M' . $rowCount, $total_fund);
                $rowCount++;
                $pre_fund=$net_fund->accumulated_fund;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="organization_installment.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
    public function download ($id){
        ini_set('max_execution_time', 0);
        ini_set('memory_limit', '4000M');
        try {

            $allResult = MemberCollectionHistory::where('member_code', $id)->get();
            $spreadsheet = new Spreadsheet();
            $activeSheet = $spreadsheet->getActiveSheet();
            $activeSheet->SetCellValue('A1', 'Organization Code');
            $activeSheet->SetCellValue('B1', 'Member Code');
            $activeSheet->SetCellValue('C1', 'Year');
            $activeSheet->SetCellValue('D1', 'Month');
            $activeSheet->SetCellValue('E1', 'Employee Contribution');
            $activeSheet->SetCellValue('F1', 'Employer Contribution');
            $activeSheet->SetCellValue('G1', 'Premium');
            $activeSheet->SetCellValue('H1', 'Accumulated Fund');
            $activeSheet->SetCellValue('I1', 'Charge');
            $activeSheet->SetCellValue('J1', 'Interest');
            $activeSheet->getStyle('A1:J1')->getFont()->setBold(true);
            $rowCount = 2;
            foreach ($allResult as $key => $value) {
                $activeSheet->SetCellValue('A' . $rowCount, $value['org_id']);
                $activeSheet->SetCellValue('B' . $rowCount, $value['member_code']);
                $activeSheet->SetCellValue('C' . $rowCount, $value['year']);
                $activeSheet->SetCellValue('D' . $rowCount, $value['month']);
                $activeSheet->SetCellValue('E' . $rowCount, $value['employeeContribution']);
                $activeSheet->SetCellValue('F' . $rowCount, $value['employerContribution']);
                $activeSheet->SetCellValue('G' . $rowCount, $value['amount']);
                $activeSheet->SetCellValue('H' . $rowCount, $value['accumulated_fund']);
                $activeSheet->SetCellValue('I' . $rowCount, $value['net_charge']);
                $activeSheet->SetCellValue('J' . $rowCount, $value['interest']);
                $rowCount++;
            }
            $writer = new Xlsx($spreadsheet);
            header('Content-Type: application/vnd.ms-excel');
            header('Content-Disposition: attachment;filename="member_installment.xlsx"');
            header('Cache-Control: max-age=0');
            ob_end_clean();
            $writer->save('php://output');
            exit();
        } catch (Exception $e) {
            return;
        }
    }
}
