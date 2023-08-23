<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Contract;
use App\Models\User;
use App\Models\Member;
use App\Models\Organization;
use App\Http\Requests\CreateMemberRequest;
use App\Http\Requests\ContractRequest;
use App\Rules\CheckEmployeeId;
use App\Services\MembersService;
use Auth;
use Illuminate\Contracts\Validation\Rule;
use Illuminate\Support\Facades\DB;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Illuminate\Http\File;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Traits\HasRoles;
class ContractController extends Controller
{
    public $model = null;
    public $service = null;

    public function __construct()
    {
        $this->model = new Contract();
        $this->service = new MembersService();
    }
    public function index(Request $request)
    {  
        $selectedOrganization = null;
        $organizations = Organization::all();
        $contracts=Contract::all();
        if ( $request->organization_id ) {
            $selectedOrganization = Organization::findOrFail($request->organization_id);
        } 
        return view('admin.contract.index_contract', compact('contracts','organizations','selectedOrganization'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $organizations = Organization::all();
        return view('admin.contract.create_contract', compact('organizations'));

    }

    /**
     * Store a newly created resouce in storager.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ContractRequest $request)
    {
        $contract= new Contract();
        $isExists = Contract::where('contract_version', $request->organization_id.'_v'.$request->contract_version)->first();
        if($isExists) {
            return back()->withErrors(['This version already exist']);
        }
        $contract->organization_id=$request->organization_id;
        $contract->contract_tittle=$request->contract_tittle;
        $contract->contract_version=$contract->organization_id.'_v'.$request->contract_version;
        $deactive_status=Contract::where('active_status',true)->update(['active_status' =>false]);
        $contract->active_status=$request->active_status;
       if($request->hasfile('contract_file')){
            $file=$request->file('contract_file');
            $extention=$file->getClientOriginalExtension();
            $file_name= $contract->contract_version.'_'.time().'.'.$extention;
            $file->storeAs('public/upload/Contract_documents', $file_name);
            $contract->file_name=$file_name;
            $contract->path='storage/upload/Contract_documents/'.$file_name;
       }
        $contract->save();
        return back()->with('success', 'Contract created successfully');        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function show(Contract $contract)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function edit(Contract $contract)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Contract $contract)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Contract  $contract
     * @return \Illuminate\Http\Response
     */
    public function destroy(Contract $contract)
    {
        //
    }
    public function download($id)
    {
        $data =Contract::where('id',$id)->first();
        $pathToFile=storage_path("app/public/upload/Contract_documents/{$data->contract_file}");
        return response()->download($pathToFile);
    }
}
