<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\Member;
use App\Models\Claim;
use App\Models\Document;
use App\Models\Organization;
use App\Models\MemberCollectionHistory;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\CreateContractRequest;
use App\Models\ClaimPayment;
use App\Models\ClaimStatus;
use App\Rules\CheckEmployeeId;
use App\Services\MembersService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Validation\Rule;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use GrahamCampbell\ResultType\Success;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Redirect;


class ClaimsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $selectedOrganization = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        return view('admin.claim.intimate_claim', compact('organizations', 'selectedOrganization'));
    }
    public function docRequiredIndex(Request $request)
    {
        $selectedOrganization = null;
        $claims = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
            $claims = Claim::where('claim_status', '=', 3)->where('organization_id', $selectedOrganization->id)->get();
        }
        //dd($claims);
        return view('admin.claim.doc_required_index', compact('organizations', 'selectedOrganization','claims'));
    }
    // public function documentIndex(Request $request)
    // {
    //     $selectedOrganization = null;
    //     $claims = null;
    //     $organizations = Organization::all();
    //     if ($request->organization_id) {
    //         $selectedOrganization = Organization::findOrFail($request->organization_id);
    //         $claims = Claim::where('claim_status', '!=', 6)->where('organization_id', $selectedOrganization->id)->get();
    //     }
    //     return view('admin.claim.process_claim', compact('organizations', 'selectedOrganization', 'claims'));
    // }

    public function processIndex(Request $request)
    {
        $selectedOrganization = null;
        $claims = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
            $claims = Claim::where('claim_status', '!=', 6)->where('claim_status', '!=', 3)->where('organization_id', $selectedOrganization->id)->get();
        }
        return view('admin.claim.process_claim', compact('organizations', 'selectedOrganization', 'claims'));
    }
    public function createProcess(Request $request, $id)
    {
        $documents = Document::where('claim_id', $request->id)->get();
        $claim = Claim::where('id', $request->id)->first();
        $member = Member::where('emp_id', $claim->emp_id)->first();
        $statuses = ClaimStatus::all();
        return view('admin.claim.process_form', compact('documents', 'claim', 'member', 'statuses'));
    }
    public function storeProcess(Request $request)
    {
        $claim = Claim::where('intimation_number', $request->intimation_number)->first();
        if ($claim->claim_status != 6) {
            $claim->claim_officer_remarks = $request->claim_officer_remarks??$claim->claim_officer_remarks;
            $claim->claim_status = $request->claim_status ?? $claim->claim_status;
            $claim->incident_remarks = $request->incident_remarks ?? $claim->incident_remarks;
            $claim->edited_by = Auth::user()->id;
            $claim->claim_status_updated_at = Carbon::now();
        }
        $claim_status = $request->claim_status;
        if ($claim_status == 6) {
            $claim->settled_by = Auth::user()->id;
            $claim->settlement_date = Carbon::now();
        }

        if (Auth::user()->hasRole(6)) {
            $claim->doctor_approved = $request->active_status;
            $claim->doctor_approved_at = Carbon::now();
            $claim->doctor_remarks = $request->remarks;
            if ($claim->claimed_amount < 200000 && $claim->doctor_approved==true) {
                $claim->release_for_account = 1;
            }
            //claim unsetteled 
            if($request->active_status==false){
                $claim->claim_status=1;
            }
        } elseif (Auth::user()->hasRole(7)) {
            $claim->hod_approved =  $request->active_status;
            $claim->hod_approved_at = Carbon::now();
            $claim->hod_remarks = $request->remarks;
            if ($claim->claimed_amount < 500000 && $claim->hod_approved==true) {
                $claim->release_for_account = 1;
            }
            if($request->active_status==false){
                $claim->doctor_approved= false;
                $claim->doctor_remarks= NULL;
            }
        } elseif (Auth::user()->hasRole(8)) {
            $claim->coo_approved =  $request->active_status;
            $claim->coo_approved_at = Carbon::now();
            $claim->coo_remarks = $request->remarks;
            if ($claim->claimed_amount < 800000 && $claim->coo_approved==true) {
                $claim->release_for_account = 1;
            }
            if($request->active_status==false){
                $claim->hod_approved= false;
                $claim->hod_remarks= NULL;
            }
        } elseif (Auth::user()->hasRole(9)) {
            $claim->ceo_approved =  $request->active_status;
            $claim->ceo_approved_at = Carbon::now();
            $claim->ceo_remarks = $request->remarks;
            if($claim->ceo_approved==true){
                $claim->release_for_account = 1;
            }
            if($request->active_status==false){
                $claim->coo_approved= false;
                $claim->coo_remarks= NULL;
            }
        } else {
            $claim->release_for_account = 0;
        }
        //dd($claim->release_for_account);
        $claim->save();
        return redirect()->back()->with('success', 'Claim Process status changed and Stored Succesfully');
    }

    public function claimPending(Request $request)
    {
        if (Auth::user()->hasRole(6) || Auth::user()->hasRole('Super Admin')) {
            $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('doctor_approved',false)->where('hod_remarks',NULL)->get();
        } elseif (Auth::user()->hasRole(7)) {
            $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 200000)->where('doctor_approved', true)->where('hod_approved',false)->where('coo_remarks',NULL)->get();
        } elseif (Auth::user()->hasRole(8)) {
            $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 500000)->where('hod_approved', true)->where('coo_approved',false)->where('ceo_remarks',NULL)->get();
        } elseif (Auth::user()->hasRole(9)) {
            $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 800000)->where('coo_approved',  true)->where('ceo_approved',false)->get();
        }
        return view('admin.claim.pending_claim', compact('claims'));
    }
    public function claimApprove(Request $request)
    {
        $documents = Document::where('claim_id', $request->id)->get();
        $claim = Claim::where('id', $request->id)->first();
        $member = Member::where('emp_id', $claim->emp_id)->first();
        $statuses = ClaimStatus::all();
        return view('admin.claim.approve_claim', compact('documents', 'claim', 'member', 'statuses'));
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $death_case=Claim::where('member_id',$request->member_id)->where('claim_type','Death')->where('claim_status','!=', 3)->first();
        if(!empty($death_case)){
            return redirect()->back()->with('error', 'This member already done a death claim');
        }
        else
        {
            // dd($death_case->intimation_number);
            $claim = Claim::where('member_id',$request->member_id)->where('claim_status',3)->first()??new Claim;
            $count = 0;
            $claim->organization_id = $request->organization_id;
            $claim->emp_id = $request->emp_id;
            $claim->claim_status =1;
            $claim->member_id = $request->member_id;
            $claim->intimation_number = $claim->intimation_number??$request->member_id . rand(0, 99999) . (carbon::now())->format('-y');
            $claim->claim_type = $request->claim_type??$claim->claim_type;
            $claim->incident_remarks = $request->incident_remarks??$claim->incident_remarks;
            $claim->incident_date = $request->incident_date??$claim->incident_date;
            $accumulated_fund = MemberCollectionHistory::where('member_id', $request->emp_id)->latest()->first()->accumulated_fund??0;
           //
            $sum_at_risk = $request->employee_sum_at_risk;
            if ($request->claim_type == 'Death') {
                $c_amount = $accumulated_fund + $sum_at_risk;
            } elseif ($request->claim_type == 'Withdrawal with plan A') {
                $c_amount = $accumulated_fund - ($accumulated_fund * 0.005);
            } elseif ($request->claim_type == 'Withdrawal with plan B') {
                $c_amount = $accumulated_fund / 2;
            }
            else{
                $c_amount = $claim->claimed_amount;
            }
            $claimed_amount=(int) round(($c_amount), 0)??$claim->claimed_amount;
            //dd($claimed_amount);
            $claim->claimed_amount=$claimed_amount;
            $claim->claim_status_updated_at = Carbon::now();
            $claim->created_by = Auth::user()->id;
            $claim->save();
            
            if ($request->hasfile('claim_files')) {
                foreach ($request->file('claim_files') as $file) {
                    $extention = $file->getClientOriginalExtension();
                    $document = new Document();
                    $baseName = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);
                    $file_name = $request->member_id. '__' . $baseName . time() . '.' . $extention;
                    $file->storeAs('public/upload/claim_documents', $file_name);
                    $document->claim_id = $claim->id;
                    $document->member_id = $request->member_id;
                    $document->intimation_number = $claim->intimation_number;
                    $document->claim_files = $file_name;
                    $document->path = 'storage/upload/claim_documents' . $file_name;
                    $document->save();
                }
            }
            return back()->with('success', 'Claim Intimated Sucessfully');
        }

    }


    public function claimRivew(Request $request)
    {
        {
            if (Auth::user()->hasRole(6) || Auth::user()->hasRole('Super Admin')) {
                $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('hod_approved',false)->whereNotNull('hod_remarks')->where('doctor_approved',false)->get();
            } elseif (Auth::user()->hasRole(7)) {
                $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 200000)->where('doctor_approved', true)->where('hod_approved',false)->where('coo_approved',false)->whereNotNull('coo_remarks')->get();
            } elseif (Auth::user()->hasRole(8)) {
                $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 500000)->where('hod_approved',true)->where('ceo_approved',false)->where('coo_approved',false)->whereNotNull('ceo_remarks')->get();
            } elseif (Auth::user()->hasRole(9)) {
                $claims = Claim::where('claim_status', 6)->where('release_for_account', false)->where('claimed_amount', '>', 800000)->where('coo_approved',true)->get();
            }
            return view('admin.claim.ask_rivew', compact('claims'));
        }
    }

    public function underprocessing(Request $request)
    {
        $claims = Claim::where('claim_status',1)->get();
        return view('admin.claim.underprocess', compact('claims'));
    }
    public function docRequired(Request $request)
    {
        $claims = Claim::where('claim_status',3)->get();
        return view('admin.claim.docRequired', compact('claims'));
    }
    public function eftReturn(Request $request)
    {
        $selectedOrganization = null;
        $claims = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
            $claims= ClaimPayment::where('org_id', $selectedOrganization->id)->where('return_eft',true)->get();
        }
        return view('admin.claim.eft_return', compact('claims','selectedOrganization','organizations'));
    }
    public function eftReturnEdit(Request $request,$id)
    {
        // dd($id);
        $claims=ClaimPayment::where('id',$request->id)->first();
        return view('admin.claim.eft_return_edit', compact('claims'));
    }
    public function eftReturnCancel(Request $request)
    {
        $claim=Claim::where('intimation_number',$request->intimation_number)->first();
        $member=Member::where('id',$claim->member->id)->first();
        $claimPayment=ClaimPayment::where('intimation_number',$request->intimation_number)->first();
        $member->bank_name=$request->bank_name;
        $member->bank_branch_routing_number=$request->routing_no;
        $member->bank_account_number=$request->account_no;
        $member->updated_by=Auth::id();
        $member->updated_at=now();
        $claim->payment_done=false;
        $claim->eft_return_updated=true;
        $claim->eft_return_updated_by=Auth::id();
        $claimPayment->return_eft=false;
        $member->save();
        if($member->save()){
            $claimPayment->save();
            $claim->save();
        }
        return Redirect::route('claims.eft.return')->with('success','Member Information Update Sucessfully');
    }
    public function report(Request $request)
    {
        $selectedOrganization = null;
        $selectedStatus = null;
        $organizations = Organization::all();
        if ($request->organization_id) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        }
        $claimStatus = ClaimStatus::all();
        if ($request->status_id) {
            $selectedStatus = ClaimStatus::findOrFail($request->status_id);
        }
        $data['request'] = $request->all();
        // dd($data['request'] );
        $query = Claim::query();
        if ($request->startDate && $request->endDate) {
            $array = [
                date('Y-m-d', strtotime($request->startDate)),
                date('Y-m-d', strtotime($request->endDate))
            ];
            $query = $query->whereBetween('created_at', $array);
        }  
        if($request->status_id !=''){
            $query->where('claim_status',$selectedStatus->id);
        }      
        if ($request->memberCode != "") {
        $query->where('member_id',$request->memberCode);
        }
        elseif($request->organization_id !=''){
            $query->where('organization_id',$selectedOrganization->id);
        }
        else{
            $query;
        }
        $claims=$query->get();
        if ($request->submit == "download"){
            ini_set('max_execution_time', 0);
            ini_set('memory_limit', '4000M');
            try {
    
                $allResult = $claims;
                $spreadsheet = new Spreadsheet();
                $activeSheet = $spreadsheet->getActiveSheet();
                $activeSheet->SetCellValue('A1', 'Organization Code');
                $activeSheet->SetCellValue('B1', 'Member Code');
                $activeSheet->SetCellValue('C1', 'Intimation No');
                $activeSheet->SetCellValue('D1', 'Claim Type');
                $activeSheet->SetCellValue('E1', 'Incident Date');
                $activeSheet->SetCellValue('F1', 'Claimed Amount');
                $activeSheet->SetCellValue('G1', 'Rivew');
                $activeSheet->SetCellValue('H1', 'Status');
                $activeSheet->getStyle('A1:J1')->getFont()->setBold(true);
                $rowCount = 2;
                foreach ($allResult as $key => $value) {
                    $activeSheet->SetCellValue('A' . $rowCount, $value->organization['name']);
                    $activeSheet->SetCellValue('B' . $rowCount, $value['member_id']);
                    $activeSheet->SetCellValue('C' . $rowCount, $value['intimation_number']);
                    $activeSheet->SetCellValue('D' . $rowCount, $value['claim_type']);
                    $activeSheet->SetCellValue('E' . $rowCount, $value['incident_date']);
                    $activeSheet->SetCellValue('F' . $rowCount, $value['claimed_amount']);
                    $activeSheet->SetCellValue('G' . $rowCount, $value['claim_officer_remarks']);
                    $activeSheet->SetCellValue('H' . $rowCount, $value->claimsStatus['name']);
                    $rowCount++;
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
        return view('admin.claim.report',compact('organizations', 'selectedOrganization','claimStatus','claims'));
    }
    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }
    public function edit($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $claim = Claim::findOrFail($id);
        return view('edit', compact('claim'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
