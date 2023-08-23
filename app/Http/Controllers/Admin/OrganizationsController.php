<?php

namespace App\Http\Controllers\Admin;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\Organization;
use App\Models\OrganizationContact;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use App\Services\OrganizationService;
use App\Http\Requests\OrganizationRequest;

class OrganizationsController extends Controller
{
    public $org = null;
    private $service = null;

    public function __construct()
    {
        $this->org = new Organization();
        $this->service = new OrganizationService();
    }

    public function search(Request $request)
    {
        $organizations = $this->org->all();
        $contacts = $this->service->getOrganizationContacts();
        return view('admin.organizations.search', compact('organizations', 'contacts'));
    }

    public function showOrganizationCreateForm(Request $request)
    {   
        $users = User::where('status',1)->get();
        $contacts = $this->service->getOrganizationContacts();
       
        return view('admin.organizations.create', compact('users', 'contacts'));
    }

    public function createOrganization(OrganizationRequest $request)
    { 
        $orgAttr = [];
        $orgAttr['code'] = $request->code;
        $orgAttr['name'] = $request->name;
        $orgAttr['claim_payable_to'] = $request->payable_to??'';
        $orgAttr['address'] = $request->address??'';
        $orgAttr['phone'] = $request->phone??'';
        $orgAttr['email'] = $request->email??'';
        $orgAttr['contract_date'] = $request->contract_date??'';
        $orgAttr['commencement_date'] = $request->commencement_date??'';
        $orgAttr['profit_commision'] =number_format(substr($request->profit_commision, 0, -1),2);
        $orgAttr['management_expenses'] = $request->management_expenses;
        $orgAttr['employer_protion'] = number_format(substr($request->employer_protion, 0, -1),2);
        $orgAttr['employee_protion'] = number_format(substr($request->employee_protion, 0, -1),2);
        $orgAttr['sold_by'] = $request->sold_by??'';
        $orgAttr['sold_as'] = $request->sold_as??'';
        $orgAttr['marketed_by'] = $request->marketed_by??'';
        $orgAttr['bank_name'] = $request->bank_name??'';
        $orgAttr['bank_branch_name'] = $request->bank_branch_name??'';
        $orgAttr['bank_branch_routing_number'] = $request->bank_branch_routing_number??'';
        $orgAttr['bank_account_name'] = $request->bank_account_name??'';
        $orgAttr['bank_account_number'] = $request->bank_account_number??'';
        $orgAttr['is_active'] = $request->is_active??true;
        $orgAttr['created_by'] =  Auth::user()->id;
        $organization = Organization::create($orgAttr);
        return back()->with('success', 'Organization Created successfully.');
    }

    public function update(OrganizationRequest $request ,Organization $organization ){
        //dd($organization->id);
        $organization=Organization::where('code',$request->code)->first();
        try {
            DB::beginTransaction();
            $organization->code = $request->code ?? $organization->code;
            $organization->name = $request->name ?? $organization->name;
            $organization->claim_payable_to = $request->claim_payable_to ?? $organization->claim_payable_to;
            $organization->phone = $request->phone ?? $organization->phone;
            $organization->address = $request->address ?? $organization->address;
            $organization->email = $request->email ?? $organization->email;
            $organization->contract_date = $request->contract_date ?? $organization->contract_date;
            $organization->commencement_date = $request->commencement_date ?? $organization->commencement_date;
            $organization->profit_commision = $request->profit_commision ?? $organization->profit_commision;
            $organization->management_expenses = $request->management_expenses ?? $organization->management_expenses;
            $organization->employer_protion = $request->employer_protion ?? $organization->employer_protion;
            $organization->sold_by = $request->sold_by ?? $organization->sold_by;
            $organization->sold_as = $request->sold_as ?? $organization->sold_as;
            $organization->marketed_by = $request->marketed_by ?? $organization->marketed_by;
            $organization->bank_name = $request->bank_name ?? $organization->bank_name;
            $organization->bank_branch_name = $request->bank_branch_name ?? $organization->bank_branch_name;
            $organization->bank_branch_name = $request->bank_branch_name ?? $organization->bank_branch_name;
            $organization->bank_branch_routing_number = $request->bank_branch_routing_number ?? $organization->bank_branch_routing_number;
            $organization->bank_account_name = $request->bank_account_name ?? $organization->bank_account_name;
            $organization->bank_account_number = $request->bank_account_number ?? $organization->bank_account_number;
            $organization->is_active = $request->is_active ?? $organization->is_active;
            $organization->updated_by = Auth::user()->id;
            $organization->save();
            DB::commit();

            return back()->with('success', 'Organization Information updated successfully');
        } catch (\Exception $e) {
            DB::rollback();
            //dd($e);
            return back()->with('error', 'Something went wrong like duplicate entities.');
        }
    }
    public function getAllContacts(Request $request)
    {
        $contacts = OrganizationContact::all();
        return view('admin.organizations.contacts', compact('contacts'));
    }

    public function createContact(Request $request)
    {
        $validated = $request->validate([
            'phone' => 'required|unique:organization_contacts,phone|max:20',
            'email' => 'required|unique:organization_contacts,email|max:100',
        ]);

        try {
            $contact = OrganizationContact::create($request->except('_token'));
            return back()->with('success', 'Contact '.$contact->name);
        } catch (\Exception $e) {
            return back()->with('error', 'Something went wrong !');
        }
    }

    public function updateContact(Request $request)
    {
        try {
            $contact = OrganizationContact::findOrFail($request->contact_id);
            $contact->update($request->except(['_token', 'contact_id']));

            return back()->with(['message'=>'Conatct Information updated !']);
        } catch (\Exception $e) {
            return back()->withError(['Something went wrong']);
        }
    }
}
