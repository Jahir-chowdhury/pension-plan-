<form action="" method="POST" enctype="multipart/form-data" id="member-update-form">
    @csrf
    @method('PUT')
    <div class="form-group">
        <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Organization')</label>
                    <select name="organization_id" id="select_org_name" class="form-control" value="{{old('organization_name')}}">
                        <option value="">Select Organization</option>
                        @foreach($organizations as $organization)
                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                        @endforeach
                    </select>
                    @error('organization_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input_employee_name" class="required-label">@lang('Employee name')</label>
                    <input type="text" class="form-control" name="employee_name" value="{{old('employee_name')}}" id="input_employee_name" required>
                    @error('employee_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="input_member_id" class="required-label">@lang('Member Id')</label>
                    <input type="text" class="form-control" name="member_id" value="{{old('member_id')}}" id="input_member_id" required>
                    @error('member_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>


                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-member-department" class="required-label">@lang('Department')</label>
                    <input type="text" class="form-control" name="department" value="{{old('department')}}" id="input-member-department" required>
                    @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4" >
                    <label for="input-member-designation" class="required-label">@lang('Designation')</label>
                    <input type="text" class="form-control" name="designation" value="{{old('designation')}}" id="input-member-designation" required>
                    @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee_id" class="required-label">@lang('Employee ID')</label>
                    <input type="text" class="form-control" name="employee_id" value="{{old('employee_id')}}" id="input-employee_id" required>
                    @error('employee_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-nid" class="required-label">@lang('NID No.')</label>
                    <input type="text" class="form-control" id="input-employee-nid" value="{{old('employee_nid')}}" maxlength="20" name="employee_nid" required >
                    @error('employee_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Date of birth')</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}" id="input-employee-dob" required>
                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Membership Date')</label>
                    <input type="date" class="form-control" name="membership_date" value="{{old('membership_date')}}" id="input-membership-date" required>
                    @error('membership_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-mobile" class="required-label">@lang('Employee mobile')</label>
                    <input type="text" class="form-control" name="employee_mobile" value="{{old('employee_mobile')}}" id="input-employee-mobile" required>
                    @error('employee_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-email" class="">@lang('Employee Email')</label>
                    <input type="email" class="form-control" name="employee_email" value="{{old('employee_email')}}" id="input-employee-email" required>
                    @error('employee_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-salary" class="required-label">@lang('Employee Salary')</label>
                    <input type="number" class="form-control" name="employee_salary" value="{{old('employee_salary')}}" id="input-employee-salary" required>
                    @error('employee_salary') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-employee-bank-account-name" class="required-label">@lang('Epployee Bank Name')</label>
                    <input type="text" class="form-control" name="employee_bank_account_name" value="{{old('employee_bank_account_name')}}" id="input-employee-bank-account-name" required>
                    @error('employee_bank_account_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-branch-name" class="required-label">@lang('Employee bank Branch Name')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_name" value="{{old('employee_bank_branch_name')}}" id="input-bank-branch-name" required>
                    @error('employee_bank_branch_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-branch-routing-number" class="required-label">@lang('Employee bank branch routing number')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_routing_number" value="{{old('employee_bank_branch_routing_number')}}" id="input-bank-branch-routing-number" required>
                    @error('employee_bank_branch_routing_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="input-bank-account-number" class="required-label">@lang('Employee bank account number')</label>
                    <input type="text" class="form-control" name="employee_bank_account_number" value="{{old('employee_bank_account_number')}}" id="input-bank-account-number" required>
                    @error('employee_bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="col-form-label">@lang('Active Status')</label>
                    <select name="is_active" id="" class="form-control" value="{{old('is_active')}}" required >
                        <option value="{{App\Enums::MEMBER_STATUSES['ACTIVE']}}">Active</option>
                        <option value="{{App\Enums::MEMBER_STATUSES['INACTIVE']}}">InActive</option>
                    </select>
                </div>
                <!--<div class="form-group col-sm-12 col-md-4">
                    <label for="" class="col-form-label">@lang('Gender Status')</label>
                    <select name="gender" id="select-employee-gender" class="form-control" value="{{old('gender')}}" required >
                        <option value="{{App\Enums::HUMAN_GENDERS['MALE']}}">Male</option>
                        <option value="{{App\Enums::HUMAN_GENDERS['FEMALE']}}">Female</option>
                        <option value="{{App\Enums::HUMAN_GENDERS['OTHERS']}}">Others</option>
                    </select>
                </div>
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="col-form-label">@lang('Maritual Status')</label>
                    <select name="maritial_status" id="select-employee-maritial-status" class="form-control" value="{{old('maritial_status')}}" required >
                        <option value="{{App\Enums::HUMAN_MARITIAL_STATUSES['MARRIED']}}">Married</option>
                        <option value="{{App\Enums::HUMAN_MARITIAL_STATUSES['SINGLE']}}">Single</option>
                        <option value="{{App\Enums::HUMAN_MARITIAL_STATUSES['WIDOW']}}">Widow</option>
                    </select>
                </div>-->
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
                <button type="submit" class="btn btn-primary">@lang('Update Member Information')</button>
            </div>
        </div>
    </div>
</form>