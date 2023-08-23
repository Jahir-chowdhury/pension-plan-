<form action="{{route('organization.members.store')}}" method="POST" enctype="multipart/form-data">
    @csrf
    <div class="form-group">
        <div class="row">
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Organization')</label>
                    <select name="organization_name" id="" class="form-control" value="{{old('organization_name')}}">
                        <option value="">Select Organization</option>
                        @foreach($organizations as $organization)
                        <option value="{{$organization->id}}">{{$organization->name}}</option>
                        @endforeach
                    </select>
                    @error('organization_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee name')</label>
                    <input type="text" class="form-control" name="employee_name" value="{{old('employee_name')}}" required>
                    @error('employee_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Department')</label>
                    <input type="text" class="form-control" name="department" value="{{old('department')}}" required>
                    @error('department') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4" >
                    <label for="" class="required-label">@lang('Designation')</label>
                    <input type="text" class="form-control" name="designation" value="{{old('designation')}}" required>
                    @error('designation') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee ID')</label>
                    <input type="text" class="form-control" name="employee_id" value="{{old('employee_id')}}" required>
                    @error('employee_id') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('NID No.')</label>
                    <input type="text" class="form-control" id="nid" value="{{old('employee_nid')}}" maxlength="20" name="employee_nid" required >
                    @error('employee_nid') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                
                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Date of birth')</label>
                    <input type="date" class="form-control" name="date_of_birth" value="{{old('date_of_birth')}}" required>
                    @error('date_of_birth') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Membership Date')</label>
                    <input type="date" class="form-control" name="membership_date" value="{{old('membership_date')}}" required>
                    @error('membership_date') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Gender')</label>
                    <select name="gender" id="" class="form-control" value="{{old('gender')}}" required>
                        @foreach ( App\Enums::HUMAN_GENDERS as $key=>$gender ) 
                        <option value="{{$key}}">{{$gender}}</option>     
                        @endforeach
                    </select>
                    @error('gender') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Maritial Status')</label>
                    <select name="maritial_status" id="" class="form-control" value="{{old('maritial_status')}}" required>
                        @foreach(App\Enums::HUMAN_MARITIAL_STATUSES as $key=>$status)
                        <option value="{{$key}}">{{$status}}</option>
                        @endforeach
                    </select>
                    @error('maritial_status') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee mobile')</label>
                    <input type="text" class="form-control" name="employee_mobile" value="{{old('employee_mobile')}}" required>
                    @error('employee_mobile') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="">@lang('Employee Email')</label>
                    <input type="email" class="form-control" name="employee_email" value="{{old('employee_email')}}" required>
                    @error('employee_email') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee Salary')</label>
                    <input type="number" class="form-control" name="employee_salary" value="{{old('employee_salary')}}" required">
                    @error('employee_salary') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Epployee Bank Name')</label>
                    <input type="text" class="form-control" name="employee_bank_account_name" value="{{old('employee_bank_account_name')}}" required>
                    @error('employee_bank_account_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee bank Branch Name')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_name" value="{{old('employee_bank_branch_name')}}" required>
                    @error('employee_bank_branch_name') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee bank branch routing number')</label>
                    <input type="text" class="form-control" name="employee_bank_branch_routing_number" value="{{old('employee_bank_branch_routing_number')}}" required>
                    @error('employee_bank_branch_routing_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>

                <div class="form-group col-sm-12 col-md-4">
                    <label for="" class="required-label">@lang('Employee bank account number')</label>
                    <input type="text" class="form-control" name="employee_bank_account_number" value="{{old('employee_bank_account_number')}}" required>
                    @error('employee_bank_account_number') <small class="text-danger">{{ $message }}</small> @enderror
                </div>
        </div>

        <!--<div class="row">
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
        </div>-->

        <div class="row">
            <div class="form-group col-sm-12 col-md-4">
                <button type="submit" class="btn btn-primary">@lang('Create this member')</button>
            </div>
        </div>
    </div>
</form>