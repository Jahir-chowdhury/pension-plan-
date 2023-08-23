<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\PaymentMethod;
use App\Models\ClaimPayment;
use App\Models\Claim;
use Illuminate\Database\Eloquent\Model;
use App\Models\Collection;
use App\Models\Member;
use App\Http\Requests\CollectionRequest;
use App\Models\MemberCollectionHistory;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redirect;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PDF;
class CollectionsController extends Controller
{
    public $currentYear = 0;
    public $currentMonth = 0;

    public function __construct()
    {
        $this->currentYear = date('Y');
        $this->currentMonth = date('m');
    }

    public function addCollectionView(Request $request)
    {
        // Form :: View
        if ( $request->isMethod('get') ) {
            $organizations = Organization::all();
            $paymentMethods = PaymentMethod::where('active_status', 1)->get();
            return view('admin.collections.add', compact('organizations', 'paymentMethods'));
        }

        // Operation
        if ( $request->isMethod('post') ) {

            try {
                DB::beginTransaction();
                $suspense = 0;
            
                $organization = Organization::findOrFail($request->organization);
                $activeMembers = $organization->activeMembers;
                $duePremium = $activeMembers->sum('premium');

                $lastPayment = Collection::where('org_id', $organization->id)->latest('created_at')->first();
                if ( $lastPayment ) {
                    $suspense = $lastPayment->suspence_amount ?? 0;
                }
                $previous_buisness_month=$lastPayment->buisness_month??Carbon::now()->subMonth();
                $previous_installment_no=$lastPayment->installment_no??0;
                $buisness_month =Carbon::parse($previous_buisness_month)->addMonth();
                $due_date =Carbon::parse($buisness_month)->addMonth();
                $installment_no =++$previous_installment_no;
                $amountWithEarlierSuspense = $request->amount + $suspense;      
                if ( $amountWithEarlierSuspense >= $duePremium ) {
                    $collection = Collection::create([
                        'org_id' => $organization->id,
                        'buisness_month' =>$buisness_month,
                        'installment_no' =>$installment_no,
                        'due_date' =>$due_date,
                        'amount' => $duePremium,
                        'payment_recieved_date' => Carbon::now(),
                        'payment_method_id' => $request->payment_method,
                        'transaction_no' => $request->transaction_no,
                        'suspence_amount' => ($amountWithEarlierSuspense - $duePremium),
                        'members_count' => $activeMembers->count(),
                        'status' => 1,
                    ]);
 

                    $membersCollectionHistoryArr = [];

                    foreach ( $activeMembers as $member ) {

                        $membersCollectionHistory =MemberCollectionHistory::where('member_code',$member->member_id)->orderBy('created_at', 'desc')->first();
                        $net_fund=$membersCollectionHistory->accumulated_fund??0;
                        $previous_installment_no=$membersCollectionHistory->installment_no??0;
                        $installment_no =++$previous_installment_no;
                        $net_interest=($net_fund*($organization->profit_commision)/100)/12;
                        $fund_value=$member->premium+$net_fund+$net_interest-$member->net_charge;
                        $membersCollectionHistoryArr[] = [
                            'org_id' => $organization->code,
                            'org_collection_id' => $collection->id,
                            'member_id' => $member->emp_id,//change from  integer and take member_id 
                            'member_code' => $member->member_id,//change from  integer and take member_id 
                            'year' => $this->currentYear,
                            'month' => $this->currentMonth,
                            'installment_no' => $installment_no,
                            'employeeContribution' => $member->employeeContribution,
                            'employerContribution' => $member->employerContribution,
                            'amount' => $member->premium,
                            'interest' => $net_interest,
                            'accumulated_fund' => $fund_value,
                            'net_charge' => $member->net_charge,
                            'status' => 1,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ];
                    }
                    MemberCollectionHistory::insert($membersCollectionHistoryArr);
                }
                DB::commit();
                return back()->with('success', 'Payment successful.');
            } catch (\Exception $e) {
                DB::rollback();
                return back()->with('error', 'Something went wrong'.$e->getMessage());
            }
            
            
        }
        
    }

    public function collectionHistory(Request $request)
    {
        $collections = null;
        $years = [2021, 2022, 2023];
        $months = [
            1 => 'January',
            2 => 'February',
            3 => 'March',
            4 => 'April',
            5 => 'May',
            6 => 'June',
            7 => 'July',
            8 => 'August',
            9 => 'September',
            10 => 'October',
            11 => 'November',
            12 => 'December'
        ];

        $query = Collection::query();

        if ( $request->org_id ) {
            $query->where('org_id', $request->org_id);
        }
        if ( $request->year ){
            $query->where('year', $request->year);
        }
        if ( $request->month ) {
            $query->where('month', $request->month);
        }
        $collections = $query->get();
        $organizations = Organization::all();
        return view('admin.collections.history', compact('organizations', 'collections', 'years', 'months'));
    }

    public function ajaxGetOrganizationDetailsForCollectionForm(Request $request, $orgId)
    {
        $data = [];
        $organization = Organization::findOrFail($orgId);        
        $members = $organization->activeMembers;

        $lastPayment = Collection::where('org_id', $orgId)->latest('created_at')->first();
        
        $data['due_premium'] = ceil($members->sum('premium'));
        $data['active_members'] = $members->count('id');
        $data['last_payment'] = $lastPayment ?? 0;
        
        return response()->json($data);
    }
    public function approvedClaims(Request $request)
    {
        if(!empty($request->intimation_no)){
            $claims=Claim::where('intimation_number',$request->intimation_no)->where('release_for_account',1)->where('payment_done',false)->where('eft_return_updated',true)->get();
        }else{
            $claims=Claim::where('release_for_account',1)->where('payment_done',false)->where('eft_return_updated',true)->get();
        }
        return view('admin.collections.approve_claims_list', compact('claims'));
    }
    public function claimPayment(Request $request)
    {
        $claim=Claim::where('id',$request->id)->first();
        $organization=Organization::where('id',$claim->organization_id)->first();
        $paymentMethods = PaymentMethod::where('active_status', 1)->get();
        return view('admin.collections.claim_payment', compact('claim','organization','paymentMethods'));
    }
    public function claimPaymentStore(Request $request)
    {
        $claim=Claim::where('intimation_number',$request->intimation_number)->first();
        $claimPayment=ClaimPayment::where('advise_no',$request->advise)->get();
        $pre_sum=$claimPayment->sum('paid_amount');
        if(($pre_sum+$request->settled_amount)>1000000){
            return redirect()->back()->with('error', 'This Advise Reach Limit Of 10 Lakh');  
        }
        $claimPayment=ClaimPayment::where('intimation_number',$request->intimation_number)->first();
        $claim_payment=$claimPayment??new ClaimPayment();
        $claim_payment->claim_id=$claim->id;
        $claim_payment->claim_type=$claim->claim_type;
        $claim_payment->intimation_number=$request->intimation_number;
        $claim_payment->payment_date=$request->payment_date;
        $claim_payment->old_advise_no=$claimPayment->advise_no??null;
        $claim_payment->advise_no=$request->advise;
        $claim_payment->settled_amount=$request->settled_amount;
        $claim_payment->paid_amount=$request->settled_amount;
        $claim_payment->payment_chanel=$request->payment_chanel;
        $claim_payment->payment_method=$request->payment_method;
        $claim_payment->org_id=$claim->organization_id;
        $claim_payment->member_id=$claim->member_id;
        $claim_payment->remarks=$request->remarks;
        $claim_payment->return_eft=False;
        $claim_payment->save();
        $claim->payment_done=true;
        $claim->save();
        return Redirect::route('collection.advise')->with('success', 'claim_payment created successfully');  
    }
    public function dueCollectionView(Request $request)
    {
        $collections=Collection::whereDate('due_date','<',Carbon::now())->get();
        return view('admin.collections.due_collection_list', compact('collections'));
    }
    public function report(Request $request)
    {
        $selectedOrganization = null;
        $selectedStatus = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        $data['request'] = $request->all();
        $query = ClaimPayment::query();
        if ($request->startDate && $request->endDate) {
            $array = [
                date('Y-m-d', strtotime($request->startDate)),
                date('Y-m-d', strtotime($request->endDate))
            ];
            $query = $query->whereBetween('updated_at', $array);
        }
        if($request->claim_type !=''){
            $query->where('claim_type',$request->claim_type);
        }     
        if($request->returnType =='Without EFT Return'){
            $query->where('old_advise_no',null);
        }     
        if($request->returnType =='With EFT Return'){
            $query->whereNotNull('old_advise_no');
        }     
        if ($request->intimation_number != "") {
        $query->where('intimation_number',$request->intimation_number);

        }
        elseif($request->organization_id !=''){
            $query->where('org_id',$selectedOrganization->id);
        }
        else{
            $query;
        }
        $claims=$query->with('member')->get();
        $pattern = "/bra/i";
        if($request->paymentType==Null){
            $response=$claims;
        }

        if($request->paymentType=="FT"){
            $response=$claims->filter(function($claim) use($pattern){
                if(preg_match_all($pattern, $claim->member->bank_name)) {
                    return $claim;
                }
            });
        }
        if($request->paymentType=="EFT"){
            $response=$claims->filter(function($claim) use($pattern){
                if(!preg_match_all($pattern, $claim->member->bank_name)) {
                    return $claim;
                }
            });
        }
        $claims =$response;
        if($request->submit=='download_xcel' && !empty($claims)){
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '4000M');
            try {
    
                $allResult = $claims;
                $spreadsheet = new Spreadsheet();
                $activeSheet = $spreadsheet->getActiveSheet();
                $activeSheet->SetCellValue('A1', 'Organization Code');
                $activeSheet->SetCellValue('B1', 'Organization Name');
                $activeSheet->SetCellValue('C1', 'Payable To');
                $activeSheet->SetCellValue('D1', 'Intimation No');
                $activeSheet->SetCellValue('E1', 'Claim Type');
                $activeSheet->SetCellValue('F1', 'Claimed Amount');
                $activeSheet->SetCellValue('G1', 'Bank Name');
                $activeSheet->SetCellValue('H1', 'Account No');
                $activeSheet->SetCellValue('I1', 'routing No');
                $activeSheet->getStyle('A1:I1')->getFont()->setBold(true);
                $rowCount = 2;
                foreach ($allResult as $key => $value) {
                    $activeSheet->SetCellValue('A' . $rowCount, $value->organization['code']);
                    $activeSheet->SetCellValue('B' . $rowCount, $value->organization['name']);
                    $activeSheet->SetCellValue('C' . $rowCount, $value->member['name']);
                    $activeSheet->SetCellValue('D' . $rowCount, $value['intimation_number']);
                    $activeSheet->SetCellValue('E' . $rowCount, $value->claim['claim_type']);
                    $activeSheet->SetCellValue('F' . $rowCount, $value->claim['claimed_amount']);
                    $activeSheet->SetCellValue('G' . $rowCount, $value->member['bank_name']);
                    $activeSheet->SetCellValue('H' . $rowCount, $value->member['bank_account_number']);
                    $activeSheet->SetCellValue('I' . $rowCount, $value->member['bank_branch_routing_number']);
                    $rowCount++;
                }
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename=payment_done_list.xlsx');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit();
            } catch (Exception $e) {
                return;
            }
        }
        session()->flashInput($request->input());
        return view('admin.collections.report', compact('organizations','claims'));
    }
    public function advise(Request $request)
    {
        $selectedOrganization = null;
        $selectedStatus = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        $data['request'] = $request->all();
        // dd($data['request'] );
        $query = Claim::query()->where('payment_done',false)->where('release_for_account',true)->where('eft_return_updated',false);
        if ($request->startDate && $request->endDate) {
            $array = [
                date('Y-m-d', strtotime($request->startDate)),
                date('Y-m-d', strtotime($request->endDate))
            ];
            $query = $query->whereBetween('created_at', $array);
        }  
        if($request->claim_type !=''){
            $query->where('claim_type',$request->claim_type);
        }      
   
        if ($request->intimation_number != "") {
        $query->where('intimation_number',$request->intimation_number);

        }
        elseif($request->organization_id !=''){
            $query->where('organization_id',$selectedOrganization->id);
            
        }
        else{
            $query;
        }
        $claims=$query->with('member')->get();
        $pattern = "/bra/i";
        if($request->paymentType==Null){
            $response=$claims;
        }

        if($request->paymentType=="FT"){
            $response=$claims->filter(function($claim) use($pattern){
                if(preg_match_all($pattern, $claim->member->bank_name)) {
                    return $claim;
                }
            });
        }
        if($request->paymentType=="EFT"){
            $response=$claims->filter(function($claim) use($pattern){
                if(!preg_match_all($pattern, $claim->member->bank_name)) {
                    return $claim;
                }
            });
        }
        $claims =$response;
        session()->flashInput($request->input());
        return view('admin.collections.advise', compact('organizations','claims'));
    }
    public function adviseDownload(Request $request)
    {
        $advise_no=$request->advise_no;
        $adviseInfo=ClaimPayment::with('organization','member','claim',)->where('advise_no',$advise_no)->get();

        // $adviseInfo=ClaimPayment::with('organization','member','claim',)->where('advise_no',$advise_no)->get();
        // $total=$adviseInfo->sum('paid_amount');
        // $advise=ClaimPayment::where('advise_no',$advise_no)->first();
        // $payment_method=$advise->PaymentMethod->account_no;
        function numberTowords($num)
        {

            $ones = array(
            0 =>"ZERO",
            1 => "ONE",
            2 => "TWO",
            3 => "THREE",
            4 => "FOUR",
            5 => "FIVE",
            6 => "SIX",
            7 => "SEVEN",
            8 => "EIGHT",
            9 => "NINE",
            10 => "TEN",
            11 => "ELEVEN",
            12 => "TWELVE",
            13 => "THIRTEEN",
            14 => "FOURTEEN",
            15 => "FIFTEEN",
            16 => "SIXTEEN",
            17 => "SEVENTEEN",
            18 => "EIGHTEEN",
            19 => "NINETEEN",
            "014" => "FOURTEEN"
            );
            $tens = array( 
            0 => "ZERO",
            1 => "TEN",
            2 => "TWENTY",
            3 => "THIRTY", 
            4 => "FORTY", 
            5 => "FIFTY", 
            6 => "SIXTY", 
            7 => "SEVENTY", 
            8 => "EIGHTY", 
            9 => "NINETY" 
            ); 
            $hundreds = array( 
            "HUNDRED", 
            "THOUSAND", 
            "MILLION", 
            "BILLION", 
            "TRILLION", 
            "QUARDRILLION" 
            ); /*limit t quadrillion */
            $num = number_format($num,2,".",","); 
            $num_arr = explode(".",$num); 
            $wholenum = $num_arr[0]; 
            $decnum = $num_arr[1]; 
            $whole_arr = array_reverse(explode(",",$wholenum)); 
            krsort($whole_arr,1); 
            $rettxt = ""; 
            foreach($whole_arr as $key => $i){
                
            while(substr($i,0,1)=="0")
                    $i=substr($i,1,5);
            if($i < 20){ 
            /* echo "getting:".$i; */
            $rettxt .= $ones[$i]; 
            }elseif($i < 100){ 
            if(substr($i,0,1)!="0")  $rettxt .= $tens[substr($i,0,1)]; 
            if(substr($i,1,1)!="0") $rettxt .= " ".$ones[substr($i,1,1)]; 
            }else{ 
            if(substr($i,0,1)!="0") $rettxt .= $ones[substr($i,0,1)]." ".$hundreds[0]; 
            if(substr($i,1,1)!="0")$rettxt .= " ".$tens[substr($i,1,1)]; 
            if(substr($i,2,1)!="0")$rettxt .= " ".$ones[substr($i,2,1)]; 
            } 
            if($key > 0){ 
            $rettxt .= " ".$hundreds[$key]." "; 
            }
            } 
            if($decnum > 0){
            $rettxt .= " and ";
            if($decnum < 20){
            $rettxt .= $ones[$decnum];
            }elseif($decnum < 100){
            $rettxt .= $tens[substr($decnum,0,1)];
            $rettxt .= " ".$ones[substr($decnum,1,1)];
            }
            }
            return $rettxt;
        }

        if($request->submit=='download_xcel' && !empty($advise_no)){
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '4000M');
            try {
    
                $allResult = $adviseInfo;
                $spreadsheet = new Spreadsheet();
                $activeSheet = $spreadsheet->getActiveSheet();
                $activeSheet->SetCellValue('A1', 'Organization Code');
                $activeSheet->SetCellValue('B1', 'Organization Name');
                $activeSheet->SetCellValue('C1', 'Payable To');
                $activeSheet->SetCellValue('D1', 'Intimation No');
                $activeSheet->SetCellValue('E1', 'Claim Type');
                $activeSheet->SetCellValue('F1', 'Claimed Amount');
                $activeSheet->SetCellValue('G1', 'Bank Name');
                $activeSheet->SetCellValue('H1', 'Account No');
                $activeSheet->SetCellValue('I1', 'routing No');
                $activeSheet->getStyle('A1:I1')->getFont()->setBold(true);
                $rowCount = 2;
                foreach ($allResult as $key => $value) {
                    $activeSheet->SetCellValue('A' . $rowCount, $value->organization['code']);
                    $activeSheet->SetCellValue('B' . $rowCount, $value->organization['name']);
                    $activeSheet->SetCellValue('C' . $rowCount, $value->member['name']);
                    $activeSheet->SetCellValue('D' . $rowCount, $value['intimation_number']);
                    $activeSheet->SetCellValue('E' . $rowCount, $value->claim['claim_type']);
                    $activeSheet->SetCellValue('F' . $rowCount, $value->claim['claimed_amount']);
                    $activeSheet->SetCellValue('G' . $rowCount, $value->member['bank_name']);
                    $activeSheet->SetCellValue('H' . $rowCount, $value->member['bank_account_number']);
                    $activeSheet->SetCellValue('I' . $rowCount, $value->member['bank_branch_routing_number']);
                    $rowCount++;
                }
                $writer = new Xlsx($spreadsheet);
                header('Content-Type: application/vnd.ms-excel');
                header('Content-Disposition: attachment;filename='.$advise_no.'-eft.xlsx');
                header('Cache-Control: max-age=0');
                ob_end_clean();
                $writer->save('php://output');
                exit();
            } catch (Exception $e) {
                return;
            }
        }
        if($request->submit=='download_pdf' && !empty($advise_no)){
            $total=$adviseInfo->sum('paid_amount');
            // dd($total);
            $advise=ClaimPayment::where('advise_no',$advise_no)->first();
            $payment_method=$advise->PaymentMethod->first();
            $total_in_word=numberTowords($total);
            return view('advice', compact('advise_no','adviseInfo','total','total_in_word','payment_method'));

            $pdf = PDF::loadView('advice',compact('advise_no','adviseInfo','total','total_in_word','payment_method'));
    
            return $pdf->download(''.$advise_no.'-EFT'.'.pdf');
        }

        return view('admin.collections.downloadAdvise', compact('advise_no','adviseInfo'));
    }
    public function eftReturn(Request $request)
    {
        $return_eft=ClaimPayment::where('intimation_number',$request->intimation_no)->first();
        if($request->submit=="cancel"){
            $return_eft=ClaimPayment::where('intimation_number',$request->intimation_number)->where('return_eft',false)->first();
            if(!empty($return_eft)){
                $return_eft->return_eft=true;
                $return_eft->remarks=$request->remarks;
                $return_eft->save();
                return Redirect::route('collection.eft.return')->with('success', 'EFT returned successfully');
            }else{
                return Redirect::route('collection.eft.return')->with('error', 'EFT already returned ');
            }

        }
        return view('admin.collections.return_eft', compact('return_eft'));
    }
    public function underprocess(Request $request)
    {
        $return_eft=ClaimPayment::where('intimation_number',$request->intimation_no)->where('return_eft',true)->first();
        return view('admin.collections.underprocess', compact('return_eft'));
    }
    public function dueDeathPayment(Request $request)
    {
        if(!empty($request->intimation_no)){
            $claims=Claim::where('intimation_number',$request->intimation_no)->where('release_for_account',1)->where('payment_done',false)->where('claim_type','Death')->get();
        }else{
            $claims=Claim::where('release_for_account',1)->where('payment_done',false)->where('claim_type','Death')->get();
        }
        return view('admin.collections.approve_claims_list', compact('claims'));
    }
    public function totalDeathPayment(Request $request)
    {
        if(!empty($request->intimation_no)){
            $claims=Claim::where('intimation_number',$request->intimation_no)->where('release_for_account',1)->where('payment_done',true)->where('claim_type','Death')->get();
        }else{
            $claims=Claim::where('release_for_account',1)->where('payment_done',true)->where('claim_type','Death')->get();
        }
        return view('admin.collections.death_payment_done_list', compact('claims'));
    }
    public function duePlanAPayment(Request $request)
    {
        if(!empty($request->intimation_no)){
            $claims=Claim::where('intimation_number',$request->intimation_no)->where('release_for_account',1)->where('payment_done',false)->where('claim_type','Withdrawal with plan A')->get();
        }else{
            $claims=Claim::where('release_for_account',1)->where('payment_done',false)->where('claim_type','Withdrawal with plan A')->get();
        }
        return view('admin.collections.approve_claims_list', compact('claims'));
    }
    public function totalPlanAPayment(Request $request)
    {
        if(!empty($request->intimation_no)){
            $claims=Claim::where('intimation_number',$request->intimation_no)->where('release_for_account',1)->where('payment_done',true)->where('claim_type','Withdrawal with plan A')->get();
        }else{
            $claims=Claim::where('release_for_account',1)->where('payment_done',true)->where('claim_type','Withdrawal with plan A')->get();
        }
        return view('admin.collections.planA_payment_done_list', compact('claims'));
    }

}
?>