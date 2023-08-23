<form action="{{route('organization.create')}}" method="POST">
    @csrf
    
    <div class="row">
        
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_code" class="form-label required-label" >@lang('Organization Code')</label>
            <input type="text" class="form-control" id="input_code" name="code", placeholder="Enter Code" value="{{old('code')}}" required>
            @error('code') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_name" class="form-label">@lang('Organization Name')</label>
            <input type="text" id="input_name" class="form-control" name="name" placeholder="Enter Name" value="{{old('name')}}" required>
            @error('name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_payable_to" class="form-label">@lang('Payable to')</label>
            <select name="payable_to" id="input_payable_to" class="form-control" value="{{old('payable_to')}}">
                <option value="1">Organization</option>
                <option value="0">Client</option>
            </select>
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_phone" class="form-label">@lang('Organization Phone')</label>
            <input type="text" class="form-control" id="input_phone" name="phone" value="{{old('phone')}}"required>
            @error('phone') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_email" class="form-label">@lang('Organization Email')</label>
            <input type="email" class="form-control" id="input_email" name="email" value="{{old('email')}}"required>
            @error('email') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_contract_date" class="form-label">@lang('Contract date')</label>
            <input type="date" class="form-control" id="input_contract_date" name="contract_date" value="{{old('contract_date')}}"required>
            @error('contract_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_commencement_date" class="form-label">@lang('Commencement Date')</label>
            <input type="date" class="form-control" id="input_commencement_date" name="commencement_date" value="{{old('commencement_date')}}"required>
            @error('commencement_date') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_profit_commision" class="form-label">@lang('Profit Commision')</label>
            <input type="text" class="form-control" id="input_percentage" name="profit_commision" value="{{old('profit_commision')}}"required>
            @error('profit_commision') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_management_expenses" class="form-label">@lang('Management Expenses Yearly')</label>
            <input type="number" class="form-control" id="input_management_expenses" name="management_expenses" value="{{old('management_expenses')}}"required>
            @error('management_expenses') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_employer_protion" class="form-label">@lang('Employer Protion')</label>
            <input type="text" class="form-control" id="input_percentage" name="employer_protion" value="{{old('employer_protion')}}"required>
            @error('employer_protion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_employee_protion" class="form-label">@lang('Employee Protion')</label>
            <input type="text" class="form-control" id="input_percentage" name="employee_protion" value="{{old('employee_protion')}}"required>
            @error('employee_protion') <small class="text-danger">{{ $message }}</small> @enderror
        </div>
        <div class="form-group col-sm-12 col-md-4">
            <label for="input_sold_by" class="form-label">@lang('Sold By')</label>
            <input type="text" class="form-control" id="input_sold_by" name="sold_by" value="{{old('sold_by')}}">
            @error('sold_by') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_sold_as" class="form-label">@lang('Sold as')</label> 
            <input type="text" class="form-control" id="input_sold_as" name="sold_as" value="{{old('sold_as')}}">
            @error('sold_as') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_bank_name" class="form-label">@lang('Bank Name')</label>
            <input type="text" class="form-control" id="input_bank_name" name="bank_name" value="{{old('bank_name')}}"required>
            @error('bank_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_bank_branch_name" class="form-label">@lang('Bank Branch Name')</label>
            <input type="text" class="form-control" id="input_bank_branch_name" name="bank_branch_name" value="{{old('bank_branch_name')}}"required>
            @error('bank_branch_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_bank_branch_routing_number" class="form-label">@lang('Bank Branch routing number')</label>
            <input type="text" class="form-control" id="input_bank_branch_routing_number" name="bank_branch_routing_number" value="{{old('bank_branch_routing_number')}}">
            @error('bank_branch_routing_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_bank_account_number" class="form-label">@lang('Bank accouont number')</label>
            <input type="text" class="form-control" id="input_bank_account_number" name="bank_account_number" value="{{old('bank_account_number')}}"required>
            @error('bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_bank_account_name" class="form-label">@lang('Bank accouont name')</label>
            <input type="text" class="form-control" id="input_bank_account_name" name="bank_account_name" value="{{old('bank_account_name')}}"required>
            @error('bank_account_name') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_is_active">@lang('Status')</label>
            <select name="is_active" id="input_is_active" class="form-control">
                <option value="{{App\Enums::ORGANIZATION_STATUSES['ACTIVE']}}">Active</option>
                <option value="{{App\Enums::ORGANIZATION_STATUSES['INACTIVE']}}">Inactive</option>
            </select>
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_marketed_by">@lang('Marketed By')</label>
            <input type="text" name="marketed_by" id="input_marketed_by" class="form-control"value="{{old('marketed_by')}}"required>
            @error('marketed_by') <small class="text-danger">{{ $message }}</small> @enderror
        </div>

        <div class="form-group col-sm-12 col-md-4">
            <label for="input_address">@lang('Address')</label>
            <input name="address" class="form-control" id="input_address"value="{{old('address')}}"required>
            @error('address') <small class="text-danger">{{ $message }}</small> @enderror
        </div>



    </div>

    <div class="row">
        <div class="col-12"><hr></div>

        <div class="col-12">
            <button type="reset" class="btn btn-warning waves-effect waves-light">@lang('Clear')</button>
            <button type="submit" class="btn btn-primary waves-effect waves-light">@lang('Create this Organization')</button>
        </div>
    </div>
</form>
@push('custom_scripts')
<script>

    $(document).ready(function(){
    $("input[id='input_percentage']").on('input', function() {
        $(this).val(function(i, v) {
        return v.replace('%','') + '%';  });
        });
    });
</script>
@endpush