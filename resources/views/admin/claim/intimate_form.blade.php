
<form action="{{route('claims.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="form-group">
            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label for=""readonly="readonly" >@lang('Organization')</label>
                    <select name="organization_id" id="select_org_name" class="form-control"readonly="readonly" value="{{old('organization_name')}}">
                        <option value="">Select Organization</option>
                        @foreach($organizations as $organization)
                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                        @endforeach
                    </select>
                    @error('organization_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input_employee_name" >@lang('Employee name')</label>
                    <input type="text" class="form-control" name="employee_name" value="{{old('employee_name')}}" id="input_employee_name" readonly="readonly">
                    @error('employee_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input_employee_name" >@lang('Employee name')</label>
                    <input type="text" class="form-control" name="employee_name" value="{{old('employee_name')}}" id="input_employee_name" readonly="readonly">
                    @error('employee_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-member-department" >@lang('Department')</label>
                    <input type="text" class="form-control" name="department" value="{{old('department')}}" id="input-member-department" readonly="readonly">
                    @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4" >
                    <label for="input-member-designation" >@lang('Designation')</label>
                    <input type="text" class="form-control" name="designation" value="{{old('designation')}}" id="input-member-designation" readonly="readonly">
                    @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-member_id" >@lang('Member ID')</label>
                    <input type="text" class="form-control" name="member_id" value="{{old('member_id')}}" id="input-member_id" readonly="readonly">
                    @error('member_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-emp_id" >@lang('Employee ID')</label>
                    <input type="text" class="form-control" name="emp_id" value="{{old('emp_id')}}" id="input-emp_id" readonly="readonly">
                    @error('emp_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-nid" >@lang('NID No.')</label>
                    <input type="text" class="form-control" id="input-employee-nid" value="{{old('employee_nid')}}" maxlength="20" name="employee_nid" readonly="readonly" >
                    @error('employee_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-dob" >@lang('Date of birth')</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}" id="input-employee-dob" readonly="readonly">
                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" >@lang('Membership Date')</label>
                    <input type="date" class="form-control" name="membership_date" value="{{old('membership_date')}}" id="input-membership-date" readonly="readonly">
                    @error('membership_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-mobile" >@lang('Employee mobile')</label>
                    <input type="text" class="form-control" name="employee_mobile" value="{{old('employee_mobile')}}" id="input-employee-mobile" readonly="readonly">
                    @error('employee_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-email" class="">@lang('Employee Email')</label>
                    <input type="email" class="form-control" name="employee_email" value="{{old('employee_email')}}" id="input-employee-email" readonly="readonly">
                    @error('employee_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-salary" >@lang('Employee Salary')</label>
                    <input type="number" class="form-control" name="employee_salary" value="{{old('employee_salary')}}" id="input-employee-salary" readonly="readonly">
                    @error('employee_salary') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-sum_at_risk" >@lang('Employee Sum At Risk')</label>
                    <input type="number" class="form-control" name="employee_sum_at_risk" value="{{old('employee_sum_at_risk')}}" id="input-employee-sum_at_risk" readonly="readonly">
                    @error('employee_sum_at_risk') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-bank-account-name" >@lang('Epployee Bank Name')</label>
                    <input type="text" class="form-control" name="employee_bank_account_name" value="{{old('employee_bank_account_name')}}" id="input-employee-bank-account-name" readonly="readonly">
                    @error('employee_bank_account_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-branch-name" >@lang('Employee bank Branch Name')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_name" value="{{old('employee_bank_branch_name')}}" id="input-bank-branch-name" readonly="readonly">
                    @error('employee_bank_branch_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-branch-routing-number" >@lang('Employee bank branch routing number')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_routing_number" value="{{old('employee_bank_branch_routing_number')}}" id="input-bank-branch-routing-number" readonly="readonly">
                    @error('employee_bank_branch_routing_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-account-number" >@lang('Employee bank account number')</label>
                    <input type="text" class="form-control" name="employee_bank_account_number" value="{{old('employee_bank_account_number')}}" id="input-bank-account-number" readonly="readonly">
                    @error('employee_bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="row">
                <h5 class="modal-title" id="exampleModalLabel">@lang('Member Information To Intimate A Claim')</h5>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="" class="required-label">@lang('Incident Date')</label>
                    <input type="date" class="form-control" name="incident_date" value="{{old('incident_date')}}" id="input-membership-date" required>
                    @error('incident_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-6" >
                    <label for="input-intimation_number" class="required-label">@lang('Incident Remarks')</label>
                    <input type="text" class="form-control" name="incident_remarks" value="{{old('incident_remarks')}}" id="input-member-designation" required>
                    @error('incident_remarks') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            <div class="row">
                <div class="form-group col-sm-12 col-md-6">
                    <label for="" class="col-form-label required-label">@lang('Claim Types')</label>
                    <select name="claim_type" id="select-employee-claim_type" class="form-control" value="{{old('maritial_status')}}" required >
                        <option value="{{App\Enums::CLAIM_TYPES['0']}}">Death</option>
                        <option value="{{App\Enums::CLAIM_TYPES['1']}}">Withdrawl With Plan A</option>
                        <option value="{{App\Enums::CLAIM_TYPES['2']}}">Withdrawl With Plan B</option>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-6">
                    <label for="" class="required-label">@lang('Document Upload')</label>
                    <div class="controls">
                        <div class="entry input-group upload-input-group">
                            <input class="form-control" name="claim_files[]" type="file">
                            <button class="btn btn-upload btn-success btn-add" type="button">
                            <i class="fa fa-plus"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            {{--
            <div class="row">
                <div class="col-sm-12">
                    <hr />
                    <h6 style="text-decoration: underline;">@lang('Document Section')</h6>
                </div>
    
                <div class="form-group col-sm-12 col-md-4">
                        <label for="" class="">@lang('Employee Photo')</label>
                        <input type="file" class="form-control" name="file_employee_photo">
                        @error('file_employee_photo') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
    
                <div class="form-group col-sm-12 col-md-4">
                        <label for="" class="">@lang('Employee NID Card Photo')</label>
                        <input type="file" class="form-control" name="file_nid">
                        @error('file_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
            </div>
            --}}
            <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <button type="submit" class="btn btn-primary">@lang('Submit')</button>
                </div>
            </div>
        </div>
</form>
@push('custom_scripts')
    <script type="text/javascript">
        
        $(function () {
            $(document).on('click', '.btn-add', function (e) {
                e.preventDefault();

                var controlForm = $('.controls:first'),
                    currentEntry = $(this).parents('.entry:first'),
                    newEntry = $(currentEntry.clone()).appendTo(controlForm);

                newEntry.find('input').val('');
                controlForm.find('.entry:not(:last) .btn-add')
                    .removeClass('btn-add').addClass('btn-remove')
                    .removeClass('btn-success').addClass('btn-danger')
                    .html('<span class="fa fa-trash"></span>');
            }).on('click', '.btn-remove', function (e) {
                $(this).parents('.entry:first').remove();

                e.preventDefault();
                return false;
            });
        });



    </script>
@endpush